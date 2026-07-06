<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Isi awal konten halaman yang bisa diedit dari panel admin (Pengaturan).
     * firstOrCreate => idempoten: TIDAK menimpa nilai yang sudah diedit admin.
     */
    public function run(): void
    {
        $items = [
            // ---- Branding ----
            'logo_url' => '/img/logo.svg',

            // ---- Halaman Tentang ----
            'tentang_hero_title' => 'Tentang TM Menusantara',
            'tentang_hero_lead'  => 'Wadah pengabdian, pemberdayaan, pendidikan, ekonomi, dan pelestarian seni budaya yang berkelanjutan.',
            'tentang_intro_head' => 'Wadah pengabdian, pemberdayaan, dan kolaborasi.',
            'tentang_p1'         => 'Yayasan Terate Mekar Memayu Nusantara - dikenal sebagai Yayasan TM Menusantara - adalah lembaga pengabdian, pemberdayaan, pendidikan, penguatan ekonomi, pelestarian seni budaya, serta kegiatan sosial kemasyarakatan yang berkelanjutan.',
            'tentang_p2'         => 'Dibangun dengan semangat Memayu Hayuning Nusantara - nilai untuk terus memberi manfaat, menjaga harmoni kehidupan, dan memperkuat karakter - yayasan menjadi ruang kolaborasi lintas kalangan.',
            'tentang_visi'       => 'Menjadi yayasan yang terus memberi manfaat melalui pendidikan, pengabdian, ekonomi, dan seni budaya, guna mewujudkan kesejahteraan melalui eksistensi Memayu Hayuning Nusantara.',

            // ---- Halaman Program ----
            'program_hero_title' => 'Layanan yang menjawab kebutuhan nyata.',
            'program_hero_lead'  => 'Empat program unggulan - dari pendampingan pendidikan hingga pembinaan prestasi - dirancang terstruktur, terukur, dan berorientasi manfaat.',
            'prog1_tag'   => 'Mitra Solusi Diskusi Terintegrasi',
            'prog1_title' => 'Pendidikan @ Malang',
            'prog2_tag'   => 'Mitra Strategis Pengembangan Bisnis Anda',
            'prog2_title' => 'Pengembangan Bisnis & SDM',
            'prog3_tag'   => 'Hidup untuk Berprestasi',
            'prog3_title' => 'Club Cakra Buana',
            'prog4_tag'   => 'Pengabdian & Pelestarian',
            'prog4_title' => 'Sosial, Seni Budaya & Sarana Prasarana',
        ];

        foreach ($items as $k => $v) {
            Setting::firstOrCreate(['key' => $k], ['value' => $v]);
        }
    }
}
