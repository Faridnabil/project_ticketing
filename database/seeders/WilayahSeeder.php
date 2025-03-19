<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file_regional = public_path('json_wilayah/regional.json');
        $file_prov = public_path('json_wilayah/provinsi.json');
        $file_kab = public_path('json_wilayah/kabupaten.json');
        $file_kec = public_path('json_wilayah/kecamatan.json');

        $json_regional = file_get_contents($file_regional);
        $json_prov = file_get_contents($file_prov);
        $json_kab = file_get_contents($file_kab);
        $json_kec = file_get_contents($file_kec);

        $data_regional = json_decode($json_regional, true);
        $data_prov = json_decode($json_prov, true);
        $data_kab = json_decode($json_kab, true);
        $data_kec = json_decode($json_kec, true);

        echo "Memulai proses seeder data regional...\n";
        DB::table('regionals')->insert($data_regional);
        echo "Done seeder data regional...\n";

        echo "Memulai proses seeder data Provinsi...\n";
        DB::table('provinsis')->insert($data_prov);
        echo "Done seeder data Provinsi...\n";

        echo "Memulai proses seeder data Kabupaten...\n";
        DB::table('kabupatens')->insert($data_kab);
        echo "Done seeder data Kabupaten...\n";

        $chunk_kec = array_chunk($data_kec, 1000);
        foreach ($chunk_kec as $key => $chunk) {
            echo "Memulai proses seeder data Kecamatan... ke " . $key + 1 . "000\n";
            DB::table('kecamatans')->insert($chunk);
            echo "Done seeder data Kecamatan... ke " . $key + 1 . "000\n";
        }

    }
}
