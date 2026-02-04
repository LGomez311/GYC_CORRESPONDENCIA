<?php
use App\Http\Controllers\Auth\LoginController;

// Ruta para redirigir directamente al login una vez abra el proyecto
Route::get('/', function () {
    return redirect()->route('login');
});


// Vistas del super admin, index
// Vista index
Route::get('/sadmin', function () {
    return view('sadmin.index');
});
// Vista crear  licencias
Route::get('/sadmin/licencias', function () {
    return view('sadmin.clicencias');
})->name('clicencias');
// vista cusers
Route::get('/sadmin/usuarios', function () {
    return view('sadmin.cusers');
})->name('cusers');
// Vista historial
Route::get('/sadmin/historial', function () {
    return view('sadmin.historial');
})->name('historial');

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

