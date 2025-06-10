<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SipdWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_prov = public_path('json_wilayah/sipd_provinsi.json');
        $file_kab = public_path('json_wilayah/sipd_kabkot.json');
        $json_prov = file_get_contents($file_prov);
        $json_kab = file_get_contents($file_kab);
        $data_prov = json_decode($json_prov, true);
        $data_kab = json_decode($json_kab, true);

        echo "Memulai proses seeder data Provinsi...\n";
        DB::table('sipd_provinsis')->insert($data_prov);
        echo "Done seeder data Provinsi...\n";

        $chunk_kab = array_chunk($data_kab, 1000);
        foreach ($chunk_kab as $key => $chunk) {
            echo "Memulai proses seeder data kabukot... ke " . $key + 1 . "000\n";
            DB::table('sipd_kabkots')->insert($chunk);
            echo "Done seeder data kabkot... ke " . $key + 1 . "000\n";
        }
    }
}
