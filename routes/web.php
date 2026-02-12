<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sadmin\UsuarioController;
use App\Http\Controllers\Sadmin\EmpresaController;

// Alias para controllers con nombres iguales
use App\Http\Controllers\Sadmin\PagoController as SadminPagoController;
use App\Http\Controllers\Admin\PagoController as AdminPagoController;

use App\Http\Controllers\Sadmin\PlanController as SadminPlanController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;

// ================= AUTH =================

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirigir raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= DASHBOARDS =================
Route::middleware('auth:web')->group(function () {
    Route::get('/superadmin', fn() => view('sadmin.index'))->name('sadmin.index');
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
});

Route::middleware('auth:remitente')->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});

// ================= SUPER ADMIN =================
Route::prefix('sadmin')->group(function () {

    // Dashboard
    Route::get('/', fn() => view('sadmin.index'))->name('sadmin.dashboard');

    // Pagos
    Route::get('/pagos', [SadminPagoController::class, 'index'])->name('sadmin.pagos');
    Route::post('/pagos/notificar', [SadminPagoController::class, 'store'])->name('sadmin.pagos.store');

    // Planes
    Route::get('/planes', [SadminPlanController::class, 'index'])->name('cplanes');
    Route::post('/planes', [SadminPlanController::class, 'store'])->name('planes.store');
    Route::put('/planes/{id}', [SadminPlanController::class, 'update'])->name('planes.update');
    Route::delete('/planes/{id}', [SadminPlanController::class, 'destroy'])->name('planes.destroy');

    // Empresas CRUD
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::put('/empresas/{nit}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{nit}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

    // Usuarios CRUD
    Route::get('/admins', [UsuarioController::class, 'index'])->name('admins');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('sadmin.store');
    Route::put('/admins/{documento}', [UsuarioController::class, 'update'])->name('admins.update');
    Route::delete('/usuarios/{emple_doc}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

// ================= ADMIN =================
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', fn() => view('admin.index'))->name('admin.index');

    // Planes
    Route::get('/planes', [AdminPlanController::class, 'index'])->name('admin.planes');

    // Pagos
    Route::get('/pagos/{plan}', [AdminPagoController::class, 'index'])->name('admin.pagos.index');
    Route::post('/pagos', [AdminPagoController::class, 'store'])->name('pagos.store');

    // Otros recursos del admin
    Route::get('/correspondencia', fn() => view('admin.correspondencia'))->name('admin.correspondencia');
    Route::get('/usuarios', fn() => view('admin.usuarios'))->name('admin.usuarios');
});
