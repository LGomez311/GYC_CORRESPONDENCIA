<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // 👇 REGISTRAR TU MIDDLEWARE AQUÍ
        $middleware->alias([
            'licencia.activa' => \App\Http\Middleware\LicenciaActiva::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Manejar archivos demasiado grandes (exceden límites de PHP en php.ini)
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'El archivo enviado es demasiado pesado para ser procesado por el servidor.'], 413);
            }
            return back()->with('error', 'El archivo enviado supera el límite máximo permitido por el servidor. Por favor, reduzca el tamaño del archivo e intente de nuevo.');
        });
    })
    ->create();
