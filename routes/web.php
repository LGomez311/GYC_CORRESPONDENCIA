<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sadmin\UsuarioController;
use App\Http\Controllers\EmpresaController;

// Ruta para redirigir directamente al login
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= SUPER ADMIN =================

// Vista index
Route::get('/sadmin', function () {
    return view('sadmin.index');
});

// Vista crear licencias
Route::get('/sadmin/planes', function () {
    return view('sadmin.cplanes');
})->name('cplanes');

// Vista admins
Route::get('/sadmin/admins', [UsuarioController::class, 'index'])
    ->name('admins');

// ================= EMPRESAS CRUD =================
Route::prefix('sadmin')->group(function () {

    Route::get('/empresas', [EmpresaController::class, 'index'])
        ->name('empresas');

    Route::post('/empresas', [EmpresaController::class, 'store'])
        ->name('empresas.store');

    Route::put('/empresas/{nit}', [EmpresaController::class, 'update'])
        ->name('empresas.update');

    Route::delete('/empresas/{nit}', [EmpresaController::class, 'destroy'])
        ->name('empresas.destroy');
});

// ================= AUTH =================

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================= DASHBOARDS =================
Route::middleware('auth:web')->group(function () {
    Route::get('/superadmin', fn() => view('sadmin.index'))->name('sadmin.index');
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
});

Route::middleware('auth:remitente')->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});

// ================= ADMIN =================
Route::get('/correspondencia', fn() => view('admin.correspondencia'))->name('correspondencia');
Route::get('/resumen', fn() => view('admin.index'))->name('resumen');
Route::get('/usuarios', fn() => view('admin.usuarios'))->name('usuarios');
