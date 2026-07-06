<?php

namespace Database\Seeders;

use App\Models\Finance;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Akun admin panel (Filament) ----
        $this->call(AdminUserSeeder::class);

        // ---- Konten halaman dinamis (Tentang, Program) ----
        $this->call(ContentSeeder::class);

        // ---- Data contoh fitur lanjutan (galeri, agenda, laporan, sertifikat, anggota) ----
        $this->call(FeatureDemoSeeder::class);

        // ---- Program yayasan (dapat dikelola admin) ----
        $this->call(ProgramSeeder::class);

        // ---- Pengaturan awal (sama seperti prototype) ----
        Setting::put('wa', '6282332651802');
        Setting::put('email', 'info@menusantara.org');
        Setting::put('alamat', 'Gedung MCC Lt. 1, Kota Malang, Jawa Timur');
        Setting::put('proposal_url', '/files/proposal.pdf');

        // ---- Berita awal ----
        $news = [
            [
                'label' => 'Program 2026',
                'title' => 'Pendampingan Pendidikan @ Malang dibuka',
                'img'   => 'https://images.pexels.com/photos/34046709/pexels-photo-34046709.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900',
                'body'  => 'Program pendampingan calon mahasiswa dan keluarga dalam memilih kampus, jurusan, hunian, hingga kegiatan positif di Kota Malang.',
                'full'  => "Program Pendidikan @ Malang hadir sebagai mitra solusi diskusi terintegrasi bagi calon mahasiswa beserta keluarga.\n\nLayanan mencakup pendampingan memilih kampus dan jurusan, informasi hunian, kelas bahasa dan skill akademik, hingga kegiatan positif seperti olahraga, silat, dan seni budaya. Kami juga mendampingi komunikasi antara orang tua dan calon mahasiswa agar proses transisi ke dunia perkuliahan berjalan lancar.",
            ],
            [
                'label' => 'Cakra Buana',
                'title' => 'Latihan rutin bela diri prestasi & praktis',
                'img'   => 'https://images.pexels.com/photos/8070723/pexels-photo-8070723.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900',
                'body'  => 'Kelas terbuka untuk pelajar dan umum setiap Kamis & Sabtu di Gedung SKB Blimbing. Tubuh sehat, disiplin, dan berprestasi.',
                'full'  => "Club Cakra Buana membina olahraga prestasi dan seni bela diri dengan semangat \u201cHidup untuk Berprestasi\u201d.\n\nLatihan terprogram diadakan setiap Kamis & Sabtu pukul 19.00-23.00 WIB di Gedung SKB, Gg. Makam No. 30, Pandanwangi, Blimbing, Malang. Terbuka untuk pelajar dan umum, termasuk bela diri praktis bagi masyarakat dan tenaga keamanan.",
            ],
            [
                'label' => 'Kemitraan',
                'title' => 'Kolaborasi pengembangan bisnis & SDM',
                'img'   => 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900',
                'body'  => 'Yayasan membuka ruang kerja sama bagi UMKM, perusahaan, dan lembaga dalam pelatihan SDM, legalitas, pertanahan, dan perpajakan.',
                'full'  => "Melalui program Mitra Strategis Pengembangan Bisnis, yayasan membuka kolaborasi dengan UMKM, perusahaan, komunitas, dan lembaga.\n\nDukungan mencakup pelatihan dan penyediaan SDM, diskusi pengelolaan bisnis, pendampingan dokumen hukum, pertanahan, dan perpajakan, serta penguatan tata kelola usaha agar lebih tertib dan efisien.",
            ],
        ];
        foreach ($news as $n) {
            News::create($n);
        }

        // ---- Keuangan awal ----
        $fin = [
            ['type' => 'masuk',  'tgl' => '2026-01-12', 'nama' => 'Hamba Allah',            'prog' => 'Pendidikan',      'ket' => 'Donasi beasiswa',    'amt' => 2500000],
            ['type' => 'masuk',  'tgl' => '2026-02-03', 'nama' => 'PT Mitra Sejahtera',      'prog' => 'Sosial & Budaya',  'ket' => 'CSR kegiatan sosial', 'amt' => 5000000],
            ['type' => 'keluar', 'tgl' => '2026-02-20', 'nama' => 'Penyaluran beasiswa',     'prog' => 'Pendidikan',      'ket' => 'Bantuan biaya kuliah','amt' => 2000000],
            ['type' => 'masuk',  'tgl' => '2026-03-15', 'nama' => 'Komunitas Cakra Buana',   'prog' => 'Cakra Buana',     'ket' => 'Iuran & dukungan',    'amt' => 1500000],
            ['type' => 'keluar', 'tgl' => '2026-03-28', 'nama' => 'Perlengkapan latihan',    'prog' => 'Cakra Buana',     'ket' => 'Sarana prasarana',    'amt' => 1200000],
            ['type' => 'masuk',  'tgl' => '2026-04-10', 'nama' => 'Donatur Perorangan',      'prog' => 'Umum',            'ket' => 'Donasi umum',         'amt' => 1000000],
        ];
        foreach ($fin as $f) {
            Finance::create($f);
        }
    }
}
