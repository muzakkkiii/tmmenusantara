<?php

namespace Tests\Feature;

use App\Models\Certificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sertifikat_valid_ditampilkan(): void
    {
        Certificate::create([
            'kode' => 'CERT-UJI123',
            'nama' => 'Budi Peserta',
            'pelatihan' => 'Pelatihan Kepemimpinan',
            'tanggal' => '2026-01-10',
            'penandatangan' => 'Ahmad Syaifudin',
            'jabatan_ttd' => 'Ketua Yayasan',
        ]);

        $this->get('/sertifikat/CERT-UJI123')
            ->assertOk()
            ->assertSee('Budi Peserta')
            ->assertSee('Pelatihan Kepemimpinan');
    }

    public function test_sertifikat_tidak_dikenal_tetap_200(): void
    {
        $this->get('/sertifikat/CERT-TIDAKADA')->assertOk();
    }
}
