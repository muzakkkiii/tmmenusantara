<?php

namespace Database\Seeders;

use App\Models\ActivityReport;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FeatureDemoSeeder extends Seeder
{
    /**
     * Data contoh untuk fitur lanjutan agar halaman publik tidak kosong.
     * Aman dijalankan berulang: pakai firstOrCreate berbasis kunci unik.
     */
    public function run(): void
    {
        // ---- Galeri ----
        $galeri = [
            ['title' => 'Pelatihan Pendidikan @ Malang', 'img' => 'https://images.pexels.com/photos/32218913/pexels-photo-32218913.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900', 'caption' => 'Sesi pendampingan calon mahasiswa'],
            ['title' => 'Latihan Cakra Buana',          'img' => 'https://images.pexels.com/photos/19117454/pexels-photo-19117454.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900', 'caption' => 'Latihan rutin bela diri prestasi'],
            ['title' => 'Kegiatan Sosial Budaya',       'img' => 'https://images.pexels.com/photos/32327259/pexels-photo-32327259.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900', 'caption' => 'Pentas seni budaya nusantara'],
            ['title' => 'Kolaborasi Kemitraan',         'img' => 'https://images.pexels.com/photos/6647054/pexels-photo-6647054.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1200&h=900', 'caption' => 'Diskusi pengembangan bisnis & SDM'],
        ];
        foreach ($galeri as $g) {
            Gallery::firstOrCreate(['title' => $g['title']], $g);
        }

        // ---- Agenda / Kalender ----
        $now = Carbon::now();
        $events = [
            ['judul' => 'Workshop Beasiswa & Pilih Kampus', 'mulai' => $now->copy()->addDays(7)->setTime(9, 0),  'selesai' => $now->copy()->addDays(7)->setTime(12, 0), 'lokasi' => 'Gedung MCC Lt. 1, Malang', 'deskripsi' => 'Pendampingan memilih kampus, jurusan, dan strategi beasiswa.', 'status' => 'Terjadwal'],
            ['judul' => 'Latihan Rutin Cakra Buana',        'mulai' => $now->copy()->addDays(3)->setTime(19, 0), 'selesai' => $now->copy()->addDays(3)->setTime(23, 0), 'lokasi' => 'Gedung SKB Blimbing, Malang', 'deskripsi' => 'Latihan bela diri prestasi & praktis, terbuka untuk umum.', 'status' => 'Terjadwal'],
            ['judul' => 'Pentas Seni Budaya Nusantara',     'mulai' => $now->copy()->subDays(20)->setTime(15, 0), 'selesai' => $now->copy()->subDays(20)->setTime(21, 0), 'lokasi' => 'Alun-alun Kota Malang', 'deskripsi' => 'Pagelaran seni budaya bersama komunitas.', 'status' => 'Selesai'],
        ];
        foreach ($events as $e) {
            Event::firstOrCreate(['judul' => $e['judul']], $e);
        }

        // ---- Laporan Kegiatan ----
        $reports = [
            ['judul' => 'Laporan Pentas Seni Budaya Nusantara', 'tanggal' => $now->copy()->subDays(20)->toDateString(), 'lokasi' => 'Alun-alun Kota Malang', 'peserta' => 350, 'img' => 'https://images.pexels.com/photos/35474230/pexels-photo-35474230.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900', 'ringkasan' => "Kegiatan pentas seni budaya berjalan lancar dan dihadiri sekitar 350 pengunjung.\n\nAcara menampilkan tari tradisional, musik, dan demonstrasi bela diri Cakra Buana. Kegiatan ini memperkuat pelestarian seni budaya sekaligus mempererat kolaborasi komunitas."],
            ['judul' => 'Laporan Penyaluran Beasiswa Tahap I', 'tanggal' => $now->copy()->subDays(45)->toDateString(), 'lokasi' => 'Kota Malang', 'peserta' => 12, 'img' => 'https://images.pexels.com/photos/12949251/pexels-photo-12949251.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900', 'ringkasan' => "Sebanyak 12 penerima manfaat mendapatkan bantuan biaya pendidikan pada tahap pertama.\n\nPenyaluran dilakukan secara transparan dan tercatat pada laporan keuangan yayasan."],
            ['judul' => 'Laporan Bakti Sosial & Gotong Royong', 'tanggal' => $now->copy()->subDays(10)->toDateString(), 'lokasi' => 'Kabupaten Malang', 'peserta' => 120, 'img' => 'https://images.pexels.com/photos/6646923/pexels-photo-6646923.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=1600&h=900', 'ringkasan' => "Kegiatan bakti sosial menjangkau sekitar 120 warga penerima manfaat.\n\nBantuan sembako dan layanan dasar disalurkan bersama relawan dan mitra, memperkuat semangat gotong royong."],
        ];
        foreach ($reports as $r) {
            ActivityReport::firstOrCreate(['judul' => $r['judul']], $r);
        }

        // ---- Sertifikat contoh ----
        Certificate::firstOrCreate(['kode' => 'CERT-DEMO2026'], [
            'nama' => 'Budi Santoso',
            'pelatihan' => 'Pelatihan Bela Diri Prestasi Cakra Buana',
            'tanggal' => $now->copy()->subDays(20)->toDateString(),
            'penandatangan' => 'Dr. Ahmad Syaifudin, S.H., M.H.',
            'jabatan_ttd' => 'Ketua Yayasan',
        ]);

        // ---- Anggota / Relawan contoh ----
        $members = [
            ['nama' => 'Siti Aminah',  'peran' => 'Relawan', 'bidang' => 'Pendidikan',   'status' => 'Aktif'],
            ['nama' => 'Rahmat Hidayat', 'peran' => 'Pengurus', 'bidang' => 'Organisasi', 'status' => 'Aktif'],
        ];
        foreach ($members as $m) {
            Member::firstOrCreate(['nama' => $m['nama']], $m);
        }
    }
}
