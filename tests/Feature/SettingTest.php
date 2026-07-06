<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_put_lalu_get_mengembalikan_nilai(): void
    {
        Setting::put('wa', '6282332651802');
        $this->assertSame('6282332651802', setting('wa'));
    }

    public function test_get_default_untuk_key_tidak_ada(): void
    {
        $this->assertSame('default', setting('key_tidak_ada_xyz', 'default'));
    }

    public function test_put_menimpa_nilai_lama(): void
    {
        Setting::put('email', 'a@contoh.com');
        Setting::put('email', 'b@contoh.com');
        $this->assertSame('b@contoh.com', setting('email'));
        $this->assertSame(1, DB::table('settings')->where('key', 'email')->count());
    }
}
