<?php

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware admin custom dihapus; otentikasi panel ditangani Filament.

        // Header keamanan HTTP untuk semua respons (anti clickjacking/MIME-sniffing).
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        // Webhook pembayaran (Midtrans) dikirim server-ke-server tanpa token CSRF,
        // jadi endpoint callback harus dikecualikan agar tidak menghasilkan error 419.
        $middleware->validateCsrfTokens(except: [
            'donasi/callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
