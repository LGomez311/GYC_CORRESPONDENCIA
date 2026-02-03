<?php
use App\Http\Controllers\Auth\LoginController;

// Mostrar formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Procesar login
Route::post('/login', [LoginController::class, 'login']);

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboards protegidos por middleware
Route::middleware('auth:web')->group(function () {
    Route::get('/superadmin', fn() => view('empleado.superadmin'))->name('superadmin.dashboard');
    Route::get('/admin', fn() => view('empleado.admin'))->name('admin.dashboard');
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
});

Route::middleware('auth:remitente')->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});

