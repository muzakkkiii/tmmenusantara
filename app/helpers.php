<?php

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

if (!function_exists('rp')) {
    /** Format angka menjadi Rupiah: 2500000 => "Rp2.500.000" */
    function rp($n): string
    {
        return 'Rp' . number_format((float) ($n ?: 0), 0, ',', '.');
    }
}

if (!function_exists('fmt_date')) {
    /** Format tanggal => "03 Jul 2026" (bulan Indonesia) */
    function fmt_date($date): string
    {
        if (empty($date)) {
            return '-';
        }
        try {
            $d = Carbon::parse($date);
        } catch (\Throwable $e) {
            return (string) $date;
        }
        $mon = config('yayasan.months');
        return sprintf('%02d %s %d', $d->day, $mon[$d->month - 1], $d->year);
    }
}

if (!function_exists('wa_link')) {
    /** Bangun link wa.me dari nomor lokal/internasional + teks opsional */
    function wa_link($no, $txt = null): string
    {
        $n = preg_replace('/[^0-9]/', '', (string) $no);
        if (str_starts_with($n, '0')) {
            $n = '62' . substr($n, 1);
        }
        return 'https://wa.me/' . $n . ($txt ? '?text=' . rawurlencode($txt) : '');
    }
}

if (!function_exists('setting')) {
    /** Ambil nilai pengaturan dari tabel settings */
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('img_url')) {
    /**
     * Ubah nilai gambar berita menjadi URL yang bisa dipakai di <img>/CSS.
     * - URL lengkap (http/https) atau path root (/...) dikembalikan apa adanya.
     * - Path hasil upload Filament (mis. "news/foo.jpg") -> asset('storage/news/foo.jpg').
     *   (butuh: php artisan storage:link)
     */
    function img_url($v): string
    {
        $v = (string) ($v ?? '');
        if ($v === '' || $v === 'null' || $v === '0') {
            return '';
        }
        if (Str::startsWith($v, ['http://', 'https://', '/'])) {
            return $v;
        }
        return asset('storage/' . ltrim($v, '/'));
    }
}

if (!function_exists('compress_image')) {
    /**
     * Kompres & resize gambar di tempat (in-place) memakai GD.
     * - Menyusutkan lebar maksimum ke $maxW (menjaga rasio) & menurunkan kualitas.
     * - Mendukung JPEG, PNG, WEBP. Aman: diam saja bila GD tidak ada / format lain.
     */
    function compress_image(string $absPath, int $maxW = 1400, int $quality = 78): void
    {
        if (!is_file($absPath) || !function_exists('imagecreatetruecolor')) {
            return;
        }
        $info = @getimagesize($absPath);
        if ($info === false) {
            return;
        }
        [$w, $h] = $info;
        $mime = $info['mime'] ?? '';

        switch ($mime) {
            case 'image/jpeg':
                $src = @imagecreatefromjpeg($absPath);
                break;
            case 'image/png':
                $src = @imagecreatefrompng($absPath);
                break;
            case 'image/webp':
                $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($absPath) : null;
                break;
            default:
                return;
        }
        if (!$src) {
            return;
        }

        $scale = $w > $maxW ? $maxW / $w : 1.0;
        $nw = (int) max(1, round($w * $scale));
        $nh = (int) max(1, round($h * $scale));

        $dst = imagecreatetruecolor($nw, $nh);
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($dst, $absPath, $quality);
                break;
            case 'image/png':
                imagepng($dst, $absPath, 6);
                break;
            case 'image/webp':
                if (function_exists('imagewebp')) { imagewebp($dst, $absPath, $quality); }
                break;
        }
        imagedestroy($src);
        imagedestroy($dst);
    }
}

if (!function_exists('notify_admin')) {
    /**
     * Kirim notifikasi email ke admin (mis. saat ada lead/donasi baru).
     * Aman: dibungkus try/catch agar kegagalan email tidak mengganggu form.
     * Mailer default = "log" (tersimpan di storage/logs) bila SMTP belum diatur.
     */
    function notify_admin(string $subject, string $body): void
    {
        try {
            $to = setting('email', 'info@menusantara.org');
            if (empty($to)) {
                return;
            }
            Mail::raw($body, function ($m) use ($to, $subject) {
                $m->to($to)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::warning('notify_admin gagal: ' . $e->getMessage());
        }
    }
}

if (!function_exists('img_setting')) {
    /**
     * URL gambar dari pengaturan (hasil upload admin) atau default bawaan.
     * Dipakai untuk hero/banner/gambar dekoratif yang bisa diatur dari admin.
     */
    function img_setting($key, $default = ''): string
    {
        $v = setting($key);
        return ($v !== null && $v !== '') ? img_url($v) : $default;
    }
}

if (!function_exists('txt')) {
    /**
     * Teks dari pengaturan atau default bawaan (dipakai untuk judul/lead/CTA).
     * Mengembalikan default bila pengaturan kosong. Output boleh mengandung HTML
     * sederhana (mis. <em>) karena hanya diisi oleh admin.
     */
    function txt($key, $default = ''): string
    {
        $v = setting($key);
        return ($v !== null && $v !== '') ? (string) $v : $default;
    }
}
