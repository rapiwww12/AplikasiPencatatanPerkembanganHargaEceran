<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Harga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;


class BahanBakuController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-items')->only(['index']);
        $this->middleware('permission:edit-items')->only(['edit']);
        $this->middleware('permission:create-items')->only(['create']);
        $this->middleware('permission:delete-items')->only(['delete']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanBaku = BahanBaku::with('latestHarga')->get();

        return Inertia::render('bahanBaku/index', [
            'bahanBakus' => $bahanBaku,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function dashboard()
    {
        $hargas = Harga::with('BahanBaku')
            ->orderBy('tanggal', 'desc')
            ->get();

        $groupedData = [];

        foreach ($hargas as $harga) {
            $namaBahan = $harga->BahanBaku->nama;
            $tanggal = Carbon::parse($harga->tanggal);
            $hargaValue = (int) $harga->harga;
            $bulanKey = $tanggal->format('Y-m');

            if (!isset($groupedData[$namaBahan])) {
                $groupedData[$namaBahan] = [
                    'mingguan' => [],
                    'bulanan' => [],
                    '_bulanan_temp' => []
                ];
            }

            if ($tanggal->greaterThanOrEqualTo(now()->subDays(6))) {
                $groupedData[$namaBahan]['mingguan'][] = [
                    'label' => $tanggal->locale('id')->isoFormat('ddd'),
                    'harga' => $hargaValue
                ];
            }

            if (!isset($groupedData[$namaBahan]['_bulanan_temp'][$bulanKey])) {
                $groupedData[$namaBahan]['_bulanan_temp'][$bulanKey] = [
                    'total' => 0,
                    'count' => 0,
                    'label' => $tanggal->format('M')
                ];
            }

            $groupedData[$namaBahan]['_bulanan_temp'][$bulanKey]['total'] += $hargaValue;
            $groupedData[$namaBahan]['_bulanan_temp'][$bulanKey]['count'] += 1;
        }

        foreach ($groupedData as $namaBahan => &$data) {
            foreach ($data['_bulanan_temp'] as $bulan => $entry) {
                $data['bulanan'][] = [
                    'label' => $entry['label'],
                    'harga' => round($entry['total'] / $entry['count'])
                ];
            }

            unset($data['_bulanan_temp']);
        }

        return Inertia::render('dashboard', [
            'data' => $groupedData
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('bahanBaku/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        BahanBaku::create($validated);

        return redirect()->route('items.index')->with('success', 'Bahan Baku created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = BahanBaku::findOrFail($id);

        if (!$item) {
            return redirect()->route('items.index')->with('error', 'Bahan Baku not found.');
        }
        return Inertia::render('bahanBaku/edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        if (!$bahanBaku) {
            return redirect()->route('items.index')->with('error', 'Bahan Baku not found.');
        }
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        $bahanBaku->update($validated);

        return redirect()->route('items.index')->with('success', 'Bahan Baku updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        if (!$bahanBaku) {
            return redirect()->route('items.index')->with('error', 'Bahan Baku not found.');
        }

        $bahanBaku->delete();

        return redirect()->route('items.index')->with('success', 'Bahan Baku deleted successfully.');
    }

    public function createHarga(string $id){
        $bahanBaku = BahanBaku::findOrFail($id);
        return Inertia::render('bahanBaku/harga',[
            'bahanBaku' => $bahanBaku,
            'flash' => [
                'error' => session('error'),
            ],
        ]);
    }

    public function storeHarga(Request $request)
    {

        $validated = $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'harga' => 'required|numeric|min:0',
            'pasar' => 'required',
        ]);

        $tanggal = now()->toDateString();

        $exists = Harga::where('bahan_baku_id', $validated['bahan_baku_id'])
            ->where('tanggal', $tanggal)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Harga untuk bahan baku ini sudah tercatat hari ini.');
        }



        Harga::create([
            'bahan_baku_id' => $validated['bahan_baku_id'],
            'harga' => $validated['harga'],
            'tanggal' => $tanggal,
            'pasar' => $validated['pasar'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('items.index')->with('success', 'Harga berhasil ditambahkan.');
    }

    public function showHarga(string $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        if (!$bahanBaku) {
            return redirect()->route('items.index')->with('error', 'Bahan Baku not found.');
        }

        $hargas = Harga::where('bahan_baku_id', $id)
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10);

                        // dd($hargas);

        return Inertia::render('bahanBaku/show', [
            'bahanBaku' => $bahanBaku,
            'hargas' => $hargas->items(),
            'total' => $hargas->total(),
            'perPage' => $hargas->perPage(),
            'currentPage' => $hargas->currentPage(),
            'lastPage' => $hargas->lastPage(),
        ]);
    }

    public function editHarga(string $hargaId)
    {
        $harga = Harga::find($hargaId);

        return inertia('bahanBaku/editHarga', [
            'harga' => $harga,
        ]);
    }

    public function updateHarga(Request $request, string $hargaId)
    {
        $validated = $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $harga = Harga::where('id', $hargaId)
            ->first();

        $harga->harga = $validated['harga'];
        $harga->save();

        return redirect()->route('items.index')->with('success', 'Harga berhasil diperbarui.');
    }




}
