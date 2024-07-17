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
            'category_name' => 'Aplikasi SIAK Terpusat',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Aplikasi SIAK Terpusat'
        ]);

        $category = Category::create([
            'category_name' => 'Jarkomdat',
            'color' => '#ff0000',
            'description' => 'Permasalahan yang berkaitan dengan Jaringan Komunikasi Data (jarkomdat) / VPN sehingga pelayanan terganggu'
        ]);

        $category = Category::create([
            'category_name' => 'Data',
            'color' => '#ff0000',
            'description' => 'Permasalahan Data yang tidak bisa diselesaikan via aplikasi SIAK Terpusat, perlu penanganan tim kalibata'
        ]);

        $category = Category::create([
            'category_name' => 'TTE/Layanan',
            'color' => '#ff0000',
            'description' => 'Permasalahan terkait Tanda tangan elektronik (TTE), gagal/tidak bisa di TTE/Gangguan BSrE'
        ]);

        $category = Category::create([
            'category_name' => 'Informasi',
            'color' => '#ff0000',
            'description' => 'Informasi terkait Pelayanan/SIAK Terpusat'
        ]);

        $category = Category::create([
            'category_name' => 'IKD',
            'color' => '#ff0000',
            'description' => 'Permasalahan terkait Identitas Kependudukan Digital / email registrasi belum terkirim/ lupa password IKD/ Dokumen tidak muncul pada aplikasi IKD'
        ]);

        $category = Category::create([
            'category_name' => 'Regulasi',
            'color' => '#ff0000',
            'description' => 'Permasalahan terkait Masukkan/kebijakan pada aplikasi SIAK Terpusat sesuai dengan regulasi yang ada'
        ]);

        $category = Category::create([
            'category_name' => 'KTP Elektronik',
            'color' => '#ff0000',
            'description' => 'Permasalahan terkait Pencetakan/ Perekaman/ Aplikasi KTP Elektronik'
        ]);

    }
}
