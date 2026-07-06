<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Rate-limit global anti-flood: maks 120 request / menit / IP untuk halaman publik.
Route::middleware('throttle:120,1')->group(function () {

/* ---------------- PUBLIC ---------------- */
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');
Route::get('/program', [PublicController::class, 'program'])->name('program');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/berita/{news}', [PublicController::class, 'beritaShow'])->name('berita.show');
Route::get('/kemitraan', [PublicController::class, 'kemitraan'])->name('kemitraan');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda');
Route::get('/laporan-kegiatan', [PublicController::class, 'laporan'])->name('laporan');
Route::get('/transparansi', [PublicController::class, 'transparansi'])->name('transparansi');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');

// Verifikasi sertifikat publik: /sertifikat atau /sertifikat/{kode}
Route::get('/sertifikat/{kode?}', [PublicController::class, 'sertifikat'])->name('sertifikat');

/* ---------------- FORM PUBLIK ---------------- */
// Rate-limit semua form: maks 8 kiriman / menit / IP (anti-spam)
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:8,1')->name('kontak.store');

Route::get('/mitra', [PublicController::class, 'mitra'])->name('mitra');
Route::post('/mitra', [FormController::class, 'mitra'])->middleware('throttle:8,1')->name('mitra.store');

Route::get('/daftar', [PublicController::class, 'daftar'])->name('daftar');
Route::post('/daftar', [FormController::class, 'daftar'])->middleware('throttle:8,1')->name('daftar.store');

Route::get('/gabung', [PublicController::class, 'relawan'])->name('relawan');
Route::post('/gabung', [FormController::class, 'relawan'])->middleware('throttle:8,1')->name('relawan.store');

Route::post('/newsletter', [FormController::class, 'newsletter'])->middleware('throttle:8,1')->name('newsletter.store');

/* ---------------- DONASI ---------------- */
Route::get('/donasi', [DonationController::class, 'index'])->name('donasi');
Route::post('/donasi', [DonationController::class, 'store'])->middleware('throttle:8,1')->name('donasi.store');
// Webhook & finish untuk pembayaran online (Midtrans). Callback dikecualikan dari CSRF via bootstrap/app.php bila diperlukan.
Route::post('/donasi/callback', [DonationController::class, 'callback'])->name('donasi.callback');
Route::get('/donasi/selesai', [DonationController::class, 'selesai'])->name('donasi.selesai');

/* ---------------- SEO ---------------- */
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => route('beranda'),      'pri' => '1.0'],
        ['loc' => route('tentang'),      'pri' => '0.8'],
        ['loc' => route('program'),      'pri' => '0.8'],
        ['loc' => route('berita'),       'pri' => '0.7'],
        ['loc' => route('galeri'),       'pri' => '0.6'],
        ['loc' => route('agenda'),       'pri' => '0.6'],
        ['loc' => route('laporan'),      'pri' => '0.6'],
        ['loc' => route('kemitraan'),    'pri' => '0.7'],
        ['loc' => route('transparansi'), 'pri' => '0.7'],
        ['loc' => route('donasi'),       'pri' => '0.8'],
        ['loc' => route('kontak'),       'pri' => '0.6'],
    ];
    foreach (\App\Models\News::orderByDesc('id')->get() as $n) {
        $urls[] = ['loc' => route('berita.show', $n), 'pri' => '0.6'];
    }
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= '  <url><loc>' . e($u['loc']) . '</loc><changefreq>weekly</changefreq><priority>' . $u['pri'] . '</priority></url>' . "\n";
    }
    $xml .= '</urlset>';
    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

/*
 | Panel admin ditangani Filament di prefix /admin.
 | Lihat FILAMENT-SETUP.md untuk instalasi.
 */

});
