<?php
use App\Http\Controllers\Auth\LoginController;

// Ruta para redirigir directamente al login una vez abra el proyecto
Route::get('/', function () {
    return redirect()->route('login');
});

// Vistas del super admin, index

Route::get('/sadmin', function () {
    return view('sadmin.index');
});

// Mostrar formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Procesar login
Route::post('/login', [LoginController::class, 'login']);

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboards protegidos por middleware
Route::middleware('auth:web')->group(function () {
    Route::get('/superadmin', fn() => view('sadmin.index'))->name('sadmin.index');
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
});

Route::middleware('auth:remitente')->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});

