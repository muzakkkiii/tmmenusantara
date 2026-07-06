<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menambahkan header keamanan HTTP ke setiap respons.
 * - Mencegah clickjacking, MIME-sniffing, kebocoran referrer, dan
 *   membatasi izin fitur browser.
 * - HSTS hanya dikirim saat koneksi HTTPS agar tidak mengunci akses saat dev.
 * Catatan: sengaja TIDAK memasang Content-Security-Policy ketat agar panel
 * admin (Filament/Livewire/Alpine) tetap berjalan. CSP bisa ditambahkan di
 * level CDN/Cloudflare bila diperlukan.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=(), payment=()',
            'X-XSS-Protection' => '0',
        ];

        foreach ($headers as $key => $value) {
            if (! $response->headers->has($key)) {
                $response->headers->set($key, $value);
            }
        }

        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
