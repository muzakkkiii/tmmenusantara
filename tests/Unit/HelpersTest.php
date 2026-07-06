<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_rp_memformat_rupiah(): void
    {
        $this->assertSame('Rp2.500.000', rp(2500000));
        $this->assertSame('Rp0', rp(0));
        $this->assertSame('Rp0', rp(null));
    }

    public function test_wa_link_menormalkan_nomor(): void
    {
        $this->assertSame('https://wa.me/6281234567890', wa_link('081234567890'));
        $this->assertSame('https://wa.me/6285815782736', wa_link('62858-1578-2736'));
    }

    public function test_wa_link_menyertakan_teks(): void
    {
        $url = wa_link('08123', 'Halo Admin');
        $this->assertStringContainsString('?text=Halo%20Admin', $url);
    }

    public function test_fmt_date_bulan_indonesia(): void
    {
        $this->assertSame('05 Mar 2026', fmt_date('2026-03-05'));
        $this->assertSame('-', fmt_date(null));
    }

    public function test_img_url_menangani_beragam_bentuk(): void
    {
        $this->assertSame('', img_url(''));
        $this->assertSame('https://x.test/a.png', img_url('https://x.test/a.png'));
        $this->assertSame('/img/logo.svg', img_url('/img/logo.svg'));
        $this->assertStringContainsString('storage/news/a.jpg', img_url('news/a.jpg'));
    }
}
