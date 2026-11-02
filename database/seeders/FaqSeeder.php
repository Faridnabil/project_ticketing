<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara mengatasi gagal login atau lupa password akun SIAK?',
                'answer' => "Untuk kendala lupa password atau akun terkunci pada aplikasi SIAK Terpusat:\n1. Klik tombol **Lupa Password** pada halaman awal login portal.\n2. Masukkan NIK dan email kedinasan yang terdaftar.\n3. Cek tautan reset di kotak masuk email.\n4. Jika email tidak masuk atau akun terblokir, segera hubungi Administrator Dukcapil atau buat Tiket Pengaduan.",
                'keywords' => 'password,lupa,login,reset,siak,akun,terkunci',
                'category' => 'Akun & Akses',
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana prosedur pengajuan aktivasi IKD (Identitas Kependudukan Digital)?',
                'answer' => "Prosedur aktivasi IKD bagi aparatur dan masyarakat:\n1. Unduh aplikasi **Identitas Kependudukan Digital** di Google PlayStore / AppStore.\n2. Masukkan NIK, email aktif, dan nomor ponsel.\n3. Lakukan swafoto (face recognition).\n4. Datang ke petugas Disdukcapil atau Administrator SIAK terdekat untuk melakukan **Scan QR Code Aktivasi**.\n5. Buka email untuk melihat PIN aktivasi awal.",
                'keywords' => 'ikd,identitas,digital,aktivasi,ktp,scan,qr',
                'category' => 'Layanan Kependudukan',
                'is_active' => true,
            ],
            [
                'question' => 'Aplikasi SIAK Terpusat lambat atau muncul pesan Network Timeout, apa yang harus dilakukan?',
                'answer' => "Langkah penanganan kendala jaringan atau server timeout:\n1. Pastikan koneksi VPN Dukcapil / Jaringan Intranet Kemendagri dalam keadaan **Connected**.\n2. Cek stabilitas kuota dan kecepatan bandwidth minimal 2 Mbps.\n3. Bersihkan cache browser (Ctrl + Shift + R) atau gunakan browser Google Chrome versi terbaru.\n4. Jika seluruh rekan satu unit kantor mengalami hal serupa, silakan buat tiket pengaduan berkategori Jaringan/Infrastruktur.",
                'keywords' => 'timeout,lambat,jaringan,vpn,koneksi,siak,error,lemot',
                'category' => 'Jaringan & Server',
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara permohonan penggantian atau perbaikan alat cetak KTP-el / Ribbon habis?',
                'answer' => "Untuk permohonan logistik ribbon atau perbaikan mesin cetak KTP-el:\n1. Masuk ke menu **Tiket > Buat Tiket Baru**.\n2. Pilih kategori **Perangkat Keras / Hardware**.\n3. Sertakan nomor seri (*Serial Number*) printer dan foto fisik kendala.\n4. Tim Teknisi Hardware Dukcapil akan memverifikasi dan menindaklanjuti permohonan Anda.",
                'keywords' => 'printer,ktp,ribbon,cetak,hardware,perangkat,rusak',
                'category' => 'Perangkat & Hardware',
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana cara melakukan mutasi atau penambahan data Kartu Keluarga baru?',
                'answer' => "Untuk pelayanan penambahan anggota keluarga atau permohonan KK baru:\n1. Siapkan dokumen pendukung (Buku Nikah / Akta Kelahiran / Surat Pindah SKPWNI).\n2. Input data pada modul Pelayanan Kartu Keluarga di aplikasi SIAK.\n3. Lakukan verifikasi NIK anggota keluarga.\n4. Ajukan persetujuan tanda tangan elektronik (TTE) kepada Pejabat yang berwenang.",
                'keywords' => 'kk,kartu,keluarga,mutasi,tambah,anak,pindah',
                'category' => 'Layanan Kependudukan',
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
