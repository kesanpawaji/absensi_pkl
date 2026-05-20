<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ✅ Tambahkan provider tambahan manual
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        /**
         * ✅ Laravel 12 sudah tidak pakai Kernel.php
         * Jadi konfigurasi CSRF exemption dilakukan di sini.
         */
        $middleware->validateCsrfTokens(except: [
            'absensi/*',               // semua route di dalam /absensi
            'absensi/storeScan',       // pastikan route manual juga aman
        ]);

        /**
         * ✅ Tambahkan middleware alias admin
         * Tidak mengubah apapun kode lain.
         */
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAuth::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        // Di sini bisa tambahkan handler custom kalau mau log error atau ubah tampilan
    })

    ->withProviders([
        // ✅ Provider bawaan penting
        ValidationServiceProvider::class,
        TranslationServiceProvider::class,

        // ✅ Provider tambahan kamu
        DomPDFServiceProvider::class,
        QrCodeServiceProvider::class,
    ])

    ->create();
