<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Harga;
use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-laporan')->only(['index']);
        $this->middleware('permission:create-laporan')->only(['create']);
        $this->middleware('permission:download-laporan')->only(['downloadLaporan']);
    }

    public function index()
    {
        $laporans = Laporan::all()->toArray();

        return inertia('laporan/index', [
            'laporans' => $laporans,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kesimpulan' => 'required|string',
        ]);

        $months = [
            Carbon::now()->copy()->subMonths(2),
            Carbon::now()->copy()->subMonths(1),
            Carbon::now()->copy()->subMonths(0),
        ];

        $laporanData = [];

        foreach ($months as $month) {
            $bahanBakus = BahanBaku::with(['hargaItems' => function ($query) use ($month) {
                $query->whereYear('tanggal', $month->year)
                    ->whereMonth('tanggal', $month->month);
            }])->get();

            foreach ($bahanBakus as $bahanBaku) {
                $harga = $bahanBaku->hargaItems->pluck('harga');
                $averagePrice = $harga->isEmpty() ? 0 : $harga->avg();

                $laporanData[$bahanBaku->id]['nama'] = $bahanBaku->nama;
                $laporanData[$bahanBaku->id]['satuan'] = $bahanBaku->satuan;

                $laporanData[$bahanBaku->id]['harga_bulan_' . $month->format('m')] = $this->formatHarga($averagePrice);
            }
        }

        $uniquePasars = Harga::whereBetween('tanggal', [
            $months[2]->copy()->startOfMonth(),
            $months[0]->copy()->endOfMonth(),
        ])
        ->select('pasar')
        ->distinct()
        ->pluck('pasar')
        ->toArray();


        $formattedLaporanData = [];
        foreach ($laporanData as $data) {
            $formattedLaporanData[] = [
                'nama' => $data['nama'],
                'satuan' => $data['satuan'],
                'bulan_3' => $data['harga_bulan_' . $months[2]->format('m')] ?? null,
                'bulan_2' => $data['harga_bulan_' . $months[1]->format('m')] ?? null,
                'bulan_1' => $data['harga_bulan_' . $months[0]->format('m')] ?? null,
            ];
        }

        $namaBulan = collect($months)->map(fn($m) => $m->translatedFormat('F'))->toArray();

        $pdf = Pdf::loadView('laporan.pdf', [
            'laporanData' => $formattedLaporanData,
            'nama_bulan' => $namaBulan,
            'pasars' => $uniquePasars,
            'kesimpulan' => $request->kesimpulan,
        ]);

        $filename = 'laporan_' . now()->format('Ymd_His') . '.pdf';
        $path = 'laporan/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());

        $laporan = Laporan::create([
            'judul' => $request->judul,
            'kesimpulan' => $request->kesimpulan,
            'tanggal_mulai' => $months[2]->startOfMonth(),
            'tanggal_selesai' => $months[0]->endOfMonth(),
            'file_path' => $path,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dibuat!');
    }

    private function formatHarga($harga)
    {
        return is_numeric($harga) ? $harga : null;
    }

    public function downloadLaporan(string $id)
    {
        $laporan = Laporan::findOrFail($id);

        $storagePath = 'app/public/' . $laporan->file_path;
        $filePath = $laporan->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download(storage_path($storagePath), basename($filePath));
    }

}
