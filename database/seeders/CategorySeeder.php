<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::create([
            'category_name' => 'Perencanaan',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Perencanaan'
        ]);

        $category = Category::create([
            'category_name' => 'Anggaran',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Pengelolaan dana'
        ]);

        $category = Category::create([
            'category_name' => 'Penata Usahaan',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Tata Usaha'
        ]);

        $category = Category::create([
            'category_name' => 'Akutansi Pelaporan',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Akuntansi dan Pelaporan'
        ]);

        // $category = Category::create([
        //     'category_name' => 'Informasi',
        //     'color' => '#ff0000',
        //     'description' => 'Informasi terkait Pelayanan/SIAK Terpusat'
        // ]);

        // $category = Category::create([
        //     'category_name' => 'IKD',
        //     'color' => '#ff0000',
        //     'description' => 'Permasalahan terkait Identitas Kependudukan Digital / email registrasi belum terkirim/ lupa password IKD/ Dokumen tidak muncul pada aplikasi IKD'
        // ]);

        // $category = Category::create([
        //     'category_name' => 'Regulasi',
        //     'color' => '#ff0000',
        //     'description' => 'Permasalahan terkait Masukkan/kebijakan pada aplikasi SIAK Terpusat sesuai dengan regulasi yang ada'
        // ]);

        // $category = Category::create([
        //     'category_name' => 'KTP Elektronik',
        //     'color' => '#ff0000',
        //     'description' => 'Permasalahan terkait Pencetakan/ Perekaman/ Aplikasi KTP Elektronik'
        // ]);

    }
}
