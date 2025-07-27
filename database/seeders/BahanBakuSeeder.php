<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\Harga;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasars = [
            'pasar betung',
            'pasar sukomoro',
            'pasar sukajadi',
            'pasar kenten laut',
            'pasar pangkalan balai',
        ];

        $berascaplokal = BahanBaku::create([
            'nama' => 'Beras Cap Lokal (Medium)',
            'satuan' => 'kg'
        ]);

        $berascapraja = BahanBaku::create([
            'nama' => 'Beras Cap Raja Platinum (Premium)',
            'satuan' => 'kg'
        ]);

        $berascappatin = BahanBaku::create([
            'nama' => 'Beras Cap Patin (Premium)',
            'satuan' => 'kg'
        ]);

        $kedelai = BahanBaku::create([
            'nama' => 'Kedelai Impor',
            'satuan' => 'kg'
        ]);

        $Cabaikeriting = BahanBaku::create([
            'nama' => 'Cabai Merah Keriting',
            'satuan' => 'kg'
        ]);

        $Cabaibesar = BahanBaku::create([
            'nama' => 'Cabai Merah Besar',
            'satuan' => 'kg'
        ]);

        $Caberawitmerah = BahanBaku::create([
            'nama' => 'Cabai Rawit Merah',
            'satuan' => 'kg'
        ]);

        $Caberawitijo = BahanBaku::create([
            'nama' => 'Cabai Rawit Hijau',
            'satuan' => 'kg'
        ]);

        $bawangmerah = BahanBaku::create([
            'nama' => 'Bawang Merah',
            'satuan' => 'kg'
        ]);

        $gulapasircurah = BahanBaku::create([
            'nama' => 'Gula Pasir Curah',
            'satuan' => 'kg'
        ]);

        $gulapasirkemasan = BahanBaku::create([
            'nama' => 'Gula Pasir Kemasan',
            'satuan' => 'kg'
        ]);

        $minyakgorengcurah = BahanBaku::create([
            'nama' => 'Minyak Goreng Curah',
            'satuan' => 'lt'
        ]);

        $minyakgorengkemasan = BahanBaku::create([
            'nama' => 'Minyak Goreng Premium',
            'satuan' => 'lt'
        ]);
        $minyakita = BahanBaku::create([
            'nama' => 'Minyakita',
            'satuan' => 'lt'
        ]);
        $tepunterigu = BahanBaku::create([
            'nama' => 'Tepung Terigu',
            'satuan' => 'kg'
        ]);
        $dagingayam = BahanBaku::create([
            'nama' => 'Daging Ayam Ras Karkas',
            'satuan' => 'kg'
        ]);
        $telur = BahanBaku::create([
            'nama' => 'Telur Ayam Ras',
            'satuan' => 'butir'
        ]);
        $dagingpahabelakang = BahanBaku::create([
            'nama' => 'Daging Sapi Paha Belakang',
            'satuan' => 'kg'
        ]);
        $dagingpahadepan = BahanBaku::create([
            'nama' => 'Daging Sapi Paha Depan',
            'satuan' => 'kg'
        ]);
        $dagingsandung = BahanBaku::create([
            'nama' => 'Daging Sapi Sandung Lamur',
            'satuan' => 'kg'
        ]);
        $dagingtetelan = BahanBaku::create([
            'nama' => 'Daging Sapi Tetelan',
            'satuan' => 'kg'
        ]);
        $bandeng = BahanBaku::create([
            'nama' => 'Ikan Bandeng',
            'satuan' => 'kg'
        ]);
        $tongkol = BahanBaku::create([
            'nama' => 'Ikan Tongkol',
            'satuan' => 'kg'
        ]);
        $teri = BahanBaku::create([
            'nama' => 'Ikan Teri',
            'satuan' => 'kg'
        ]);
        $mie = BahanBaku::create([
            'nama' => 'Mie Instan',
            'satuan' => 'bks'
        ]);
        $bawangputih = BahanBaku::create([
            'nama' => 'Bawang Putih Honan',
            'satuan' => 'kg'
        ]);
        $bawangbomb = BahanBaku::create([
            'nama' => 'Bawang Bombai',
            'satuan' => 'kg'
        ]);
        $garamhls = BahanBaku::create([
            'nama' => 'Garam Halus',
            'satuan' => 'kg'
        ]);
        $susuktm = BahanBaku::create([
            'nama' => 'Susu Kental Manis',
            'satuan' => 'kg'
        ]);
        $tempe = BahanBaku::create([
            'nama' => 'Tempe Bungkus',
            'satuan' => 'kg'
        ]);
        $tahu = BahanBaku::create([
            'nama' => 'Tahu Putih',
            'satuan' => 'kg'
        ]);
        $udang = BahanBaku::create([
            'nama' => 'Udang Basah',
            'satuan' => 'kg'
        ]);
        $pisang = BahanBaku::create([
            'nama' => 'Pisang Lokal',
            'satuan' => 'kg'
        ]);
        $tomat = BahanBaku::create([
            'nama' => 'Tomat',
            'satuan' => 'kg'
        ]);

        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $randomPasar = $pasars[array_rand($pasars)];

            Harga::create([
                'bahan_baku_id' => $berascaplokal->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 13000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $berascapraja->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(13500, 14000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $berascappatin->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(13500, 14000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $kedelai->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $Cabaikeriting->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(20000, 25000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $Cabaibesar->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(20000, 25000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $Caberawitmerah->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(20000, 25000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];

            Harga::create([
                'bahan_baku_id' => $Caberawitijo->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(20000, 25000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $bawangmerah->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(20000, 25000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $gulapasircurah->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $gulapasirkemasan->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $minyakgorengcurah->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $minyakgorengkemasan->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $minyakita->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $tepunterigu->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $dagingayam->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $telur->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $dagingpahabelakang->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $dagingpahadepan->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $dagingsandung->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $dagingtetelan->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $bandeng->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $tongkol->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $teri->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $mie->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $bawangputih->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $bawangbomb->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];

            Harga::create([
                'bahan_baku_id' => $garamhls->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $susuktm->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $tempe->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $tahu->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $udang->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $pisang->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            $randomPasar = $pasars[array_rand($pasars)];
            Harga::create([
                'bahan_baku_id' => $tomat->id,
                'tanggal' => $date->format('Y-m-d'),
                'harga' => rand(12000, 16000),
                'pasar' => $randomPasar,
                'created_by' => 1,
            ]);
            
        }
    }
}
