<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        if (Program::count() > 0) {
            return;
        }

        $wa = Setting::get('wa', '6282332651802');

        $programs = [
            [
                'urutan' => 1,
                'tag' => 'Mitra Solusi Diskusi Terintegrasi',
                'judul' => 'Pendidikan @ Malang',
                'poin' => "Pendampingan memilih kampus dan jurusan\nInformasi hunian dan adaptasi kota\nKelas bahasa dan skill akademik\nOlahraga, silat, seni budaya, dan jejaring komunitas positif\nPendampingan komunikasi dengan orang tua dan calon mahasiswa",
                'pic_nama' => 'Joko',
                'pic_telp' => $wa,
                'info' => null,
                'visual_label' => 'Pendidikan',
                'img' => 'https://images.pexels.com/photos/12949251/pexels-photo-12949251.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=1200',
                'cta_label' => 'Daftar / Konsultasi',
                'cta_route' => 'daftar',
                'aktif' => true,
            ],
            [
                'urutan' => 2,
                'tag' => 'Mitra Strategis Pengembangan Bisnis Anda',
                'judul' => 'Pengembangan Bisnis & SDM',
                'poin' => "Pelatihan dan penyediaan SDM\nDiskusi pengelolaan bisnis\nPendampingan dokumen hukum, pertanahan, dan perpajakan\nKemitraan dengan UMKM, perusahaan, komunitas, dan lembaga\nPenguatan tata kelola usaha agar lebih tertib dan efisien",
                'pic_nama' => 'Dadang',
                'pic_telp' => $wa,
                'info' => 'Gedung MCC Lt. 1, Malang',
                'visual_label' => 'Bisnis & SDM',
                'img' => 'https://images.pexels.com/photos/34046709/pexels-photo-34046709.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=1200',
                'cta_label' => 'Daftar / Konsultasi',
                'cta_route' => 'daftar',
                'aktif' => true,
            ],
            [
                'urutan' => 3,
                'tag' => 'Hidup untuk Berprestasi',
                'judul' => 'Club Cakra Buana',
                'poin' => "Olahraga prestasi untuk pelajar dan umum\nSeni bela diri sebagai pembinaan budaya, disiplin, dan identitas\nBela diri praktis untuk masyarakat umum dan tenaga keamanan\nLatihan terprogram, terbuka untuk pelajar & umum",
                'pic_nama' => 'Sutopo',
                'pic_telp' => $wa,
                'info' => 'Gedung SKB, Blimbing - Kamis & Sabtu 19.00-23.00',
                'visual_label' => 'Olahraga & Bela Diri',
                'img' => 'https://images.pexels.com/photos/19117454/pexels-photo-19117454.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=1200',
                'cta_label' => 'Daftar Latihan',
                'cta_route' => 'daftar',
                'aktif' => true,
            ],
            [
                'urutan' => 4,
                'tag' => 'Pengabdian & Pelestarian',
                'judul' => 'Sosial, Seni Budaya & Sarana Prasarana',
                'poin' => "Kegiatan bakti sosial, kemanusiaan, dan gotong royong\nPelestarian seni budaya lokal, banjari, dan semarak budaya\nPublikasi bantuan/hibah, inventaris, dan dokumentasi sarana\nPengembangan padepokan sebagai pusat kegiatan",
                'pic_nama' => null,
                'pic_telp' => null,
                'info' => 'Kolaborasi terbuka untuk relawan & mitra',
                'visual_label' => 'Sosial & Budaya',
                'img' => 'https://images.pexels.com/photos/32327259/pexels-photo-32327259.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=1200',
                'cta_label' => 'Kolaborasi & Dukungan',
                'cta_route' => 'mitra',
                'aktif' => true,
            ],
        ];

        foreach ($programs as $p) {
            Program::create($p);
        }
    }
}
