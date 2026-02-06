<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sadmin\UsuarioController;

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
Route::get('/sadmin/planes', function () {
    return view('sadmin.cplanes');
})->name('cplanes');
// vista admins
Route::get('/sadmin/admins', function () {
    return view('sadmin.admins');
})->name('admins');
//esta vista envia datos para mostrar en tabla
Route::get('/sadmin/admins', [UsuarioController::class, 'index'])
    ->name('admins');
// Vista empresas crud
Route::get('/sadmin/empresas', function () {
    return view('sadmin.empresas');
})->name('empresas');

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



// Rutas del admin

Route::get('/correspondencia', function () {
    return view('admin.correspondencia');
})->name('correspondencia');

Route::get('/resumen', function () {
    return view('admin.index');
})->name('resumen');

Route::get('/usuarios', function () {
    return view('admin.usuarios');
})->name('usuarios');
