<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sadmin\UsuarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Sadmin\PlanController as SadminPlanController;
use App\Http\Controllers\PagoController;

Route::post('/pagos/notificar', [PagoController::class, 'store'])
    ->name('pagos.store');


Route::get('admin/pagos/{plan}', [PagoController::class, 'index'])
    ->name('admin.pagos.index');
// Ruta para redirigir directamente al login
Route::get('/', function () {
    return redirect()->route('login');
});

// ================= SUPER ADMIN =================

// Vista index
Route::get('/sadmin', function () {
    return view('sadmin.index');
});

Route::get('/sadmin/pagos', function () {
    return view('sadmin.pagos');
})->name('sadmin.pagos');

// Vista crear licencias
Route::get('/sadmin/planes', function () {
    return view('sadmin.cplanes');
})->name('cplanes');

// Vista admins
Route::get('/sadmin/admins', [UsuarioController::class, 'index'])
    ->name('admins');

Route::get('/admin/planes', [AdminPlanController::class, 'index'])
    ->name('admin.planes');

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



// Rutas del admin
Route::get('/admin/correspondencia', function () {
    return view('admin.correspondencia');
})->name('admin.correspondencia');

Route::get('admin/index', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/admin/planes', [AdminPlanController::class, 'index'])
    ->name('admin.planes');


Route::get('admin/usuarios', function () {
    return view('admin.usuarios');
})->name('admin.usuarios');

Route::get('/admin/pagos', function () {
    return view('admin.pagos');
})->name('admin.pagos');

// Rutas del plan
Route::prefix('sadmin')->group(function () {
    Route::get('/planes', [PlanController::class, 'index'])->name('cplanes');
    Route::post('/planes', [PlanController::class, 'store'])->name('planes.store');
    Route::put('/planes/{id}', [PlanController::class, 'update'])->name('planes.update');
    Route::delete('/planes/{id}', [PlanController::class, 'destroy'])->name('planes.destroy');
});

// Rutas administrador de empresas en vista sadmin
Route::post('/sadmin/usuarios', [UsuarioController::class, 'store'])
    ->name('sadmin.store');

Route::put('sadmin/admins/{documento}', [UsuarioController::class, 'update'])
    ->name('admins.update');

Route::delete('/usuarios/{emple_doc}', [UsuarioController::class, 'destroy'])
    ->name('usuarios.destroy');
