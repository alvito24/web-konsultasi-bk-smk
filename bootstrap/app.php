<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware; // <--- Wajib di-import

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // --- INI YANG BIKIN ERROR ---
        // Kita harus kenalin 'role' ke Laravel biar dia tau itu RoleMiddleware
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'profile.complete' => \App\Http\Middleware\EnsureProfileIsComplete::class, // <--- TAMBAH INI
        ]);
        // ---------------------------

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
