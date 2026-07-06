<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_kemitraan_menyimpan_data(): void
    {
        $this->post('/mitra', [
            'nama' => 'Uji Mitra',
            'organisasi' => 'PT Contoh',
            'jenis' => 'Program',
        ])->assertRedirect();

        $this->assertDatabaseHas('partners', [
            'nama' => 'Uji Mitra',
            'status' => 'Baru',
        ]);
    }

    public function test_pendaftaran_peserta_menyimpan_data(): void
    {
        $this->post('/daftar', ['nama' => 'Uji Peserta'])->assertRedirect();
        $this->assertDatabaseHas('participants', ['nama' => 'Uji Peserta', 'status' => 'Baru']);
    }

    public function test_gabung_relawan_default_peran_relawan(): void
    {
        $this->post('/gabung', ['nama' => 'Uji Relawan'])->assertRedirect();
        $this->assertDatabaseHas('members', [
            'nama' => 'Uji Relawan',
            'peran' => 'Relawan',
            'status' => 'Aktif',
        ]);
    }

    public function test_newsletter_menyimpan_email_lowercase(): void
    {
        $this->post('/newsletter', ['email' => 'Halo@Contoh.COM'])->assertRedirect();
        $this->assertDatabaseHas('subscribers', ['email' => 'halo@contoh.com', 'active' => true]);
    }

    public function test_honeypot_menolak_bot(): void
    {
        $this->post('/mitra', [
            'nama' => 'Bot Spam',
            'website' => 'http://spam.example',
        ])->assertRedirect();

        $this->assertDatabaseMissing('partners', ['nama' => 'Bot Spam']);
    }

    public function test_validasi_menolak_tanpa_nama(): void
    {
        $this->post('/daftar', [])->assertSessionHasErrors('nama');
    }
}
