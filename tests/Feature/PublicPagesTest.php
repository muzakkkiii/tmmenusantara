<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public static function halamanPublik(): array
    {
        return [
            'beranda'      => ['/'],
            'tentang'      => ['/tentang'],
            'program'      => ['/program'],
            'berita'       => ['/berita'],
            'galeri'       => ['/galeri'],
            'agenda'       => ['/agenda'],
            'laporan'      => ['/laporan-kegiatan'],
            'sertifikat'   => ['/sertifikat'],
            'transparansi' => ['/transparansi'],
            'kemitraan'    => ['/kemitraan'],
            'donasi'       => ['/donasi'],
            'kontak'       => ['/kontak'],
            'mitra'        => ['/mitra'],
            'daftar'       => ['/daftar'],
            'gabung'       => ['/gabung'],
        ];
    }

    /** @dataProvider halamanPublik */
    public function test_halaman_publik_dapat_diakses(string $url): void
    {
        $this->get($url)->assertOk();
    }

    public function test_sitemap_tersedia(): void
    {
        $this->get('/sitemap.xml')->assertOk();
    }

    public function test_halaman_tidak_dikenal_mengembalikan_404(): void
    {
        $this->get('/halaman-yang-tidak-ada-xyz')->assertNotFound();
    }
}
