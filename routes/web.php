<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Sadmin\UsuarioController;
use App\Http\Controllers\Sadmin\EmpresaController;
use App\Exports\PagosExport;
use App\Exports\LicenciasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Sadmin\PlanController;
use App\Http\Controllers\LandingController;



// Alias para controllers con nombres iguales
use App\Http\Controllers\Sadmin\PagoController as SadminPagoController;
use App\Http\Controllers\Admin\PagoController as AdminPagoController;

use App\Http\Controllers\Sadmin\PlanController as SadminPlanController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;

Route::get('/admin/historialp', [AdminPagoController::class, 'historial'])
    ->name('admin.historialp');

Route::get('/', [LandingController::class, 'index'])->name('web.index');



// Ruta de exportar excel con datos
Route::get('/admin/pagos/export/excel', function () {
    return Excel::download(new PagosExport, 'pagos.xlsx');
})->name('pagos.export.excel');

// Ruta para exportar pdf con datos
Route::get('/admin/pagos/export/pdf', function () {

    $pagos = Pago::with(['plan', 'estado'])->get();

    $pdf = Pdf::loadView('admin.pdf.pagos_pdf', compact('pagos'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('pagos.pdf');
})->name('pagos.export.pdf');
// RUTA PARA LICENCIAS - KEVIN
use App\Http\Controllers\Sadmin\LicenciaController;

// ================= AUTH =================

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ================= DASHBOARDS ================= --KEVIN SABADO 14/02--
Route::middleware(['auth:web', 'licencia.activa'])->group(function () {

    // SuperAdmin (el middleware lo deja pasar)
    Route::get('/superadmin', fn() => view('sadmin.index'))->name('sadmin.index');

    // Admin
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');

    // Empleado
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
});


Route::prefix('sadmin')
    ->middleware('auth:web')
    ->group(function () {

        // Dashboard
        Route::get('/', fn() => view('sadmin.index'))->name('sadmin.dashboard');

        // Pagos
        Route::get('/pagos', [SadminPagoController::class, 'index'])
            ->name('sadmin.pagos');

        Route::post('/pagos/{id}/aprobar', [SadminPagoController::class, 'aprobar'])
            ->name('sadmin.pagos.aprobar');

        Route::post('/pagos/{id}/denegar', [SadminPagoController::class, 'denegar'])
            ->name('sadmin.pagos.denegar');

        // Planes
        Route::get('/planes', [SadminPlanController::class, 'index'])->name('cplanes');
        Route::post('/planes', [SadminPlanController::class, 'store'])->name('planes.store');
        Route::put('/planes/{id}', [SadminPlanController::class, 'update'])->name('planes.update');
        Route::delete('/planes/{id}', [SadminPlanController::class, 'destroy'])->name('planes.destroy');

        // Empresas
        Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');
        Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
        Route::put('/empresas/{nit}', [EmpresaController::class, 'update'])->name('empresas.update');
        Route::delete('/empresas/{nit}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

        // Usuarios
        Route::get('/admins', [UsuarioController::class, 'index'])->name('admins');
        Route::post('/admins', [UsuarioController::class, 'store'])->name('admins.store');
        Route::put('/admins/{emple_doc}', [UsuarioController::class, 'update'])->name('admins.update');

        // export - excel - pdf - kevin

        // licencias - excel
        Route::get('/sadmin/licencias/export/excel', function () {
            return Excel::download(new LicenciasExport, 'licencias.xlsx');
        })->name('sadmin.licencias.export.excel');
        // licencias - pdf 
        Route::get('/sadmin/licencias/export/pdf', function () {
            $pdf = Pdf::loadView('sadmin.pdf.licencias_pdf');
            return $pdf->download('licencias.pdf');
        })->name('sadmin.licencias.export.pdf');

        // pagos excel
        Route::get('/sadmin/pagos/export/excel', function () {
            return Excel::download(new \App\Exports\PagosExport, 'pagos.xlsx');
        })->name('sadmin.pagos.export.excel');

        // pagos pdf
        Route::get('/sadmin/pagos/export/pdf', function () {
            $pagos = \App\Models\Pago::with(['plan', 'estado'])->get(); // Traes los datos que necesitas
            $pdf = Pdf::loadView('sadmin.pdf.pagos_pdf', compact('pagos'));
            return $pdf->download('pagos.pdf');
        })->name('sadmin.pagos.export.pdf');
    });


// ================= ADMIN =================
Route::prefix('admin')
    ->middleware(['auth:web', 'licencia.activa'])
    ->group(function () {

        // Dashboard
        Route::get('/', fn() => view('admin.usuarios'))->name('admin.index');

        // Planes
        Route::get('/planes', [AdminPlanController::class, 'index'])->name('admin.planes');

        // Pagos

        Route::get('/pagos/{plan}', [AdminPagoController::class, 'index'])->name('admin.pagos.index');
        Route::post('/pagos', [AdminPagoController::class, 'store'])->name('pagos.store');

        Route::get('/historialp', [AdminPagoController::class, 'historial'])->name('admin.historialp');

        // Otros recursos del admin
        Route::get('/correspondencia', fn() => view('admin.correspondencia'))->name('admin.correspondencia');
        Route::get('/usuarios', fn() => view('admin.usuarios'))->name('admin.usuarios');
    });

// Otros recursos del admin
Route::get('/correspondencia', fn() => view('admin.correspondencia'))->name('admin.correspondencia');
Route::get('/usuarios', fn() => view('admin.usuarios'))->name('admin.usuarios');


// ruta para creacion de licencias - Kevin

Route::prefix('sadmin')->name('sadmin.')->group(function () {

    Route::get('/licencias', [LicenciaController::class, 'index'])
        ->name('licencias');

    Route::post('/licencias', [LicenciaController::class, 'store'])
        ->name('licencias.store');

    Route::post('/licencias/{id}/toggle', [LicenciaController::class, 'toggle'])
        ->name('licencias.toggle');
});

//ruta remitente - Kevin

Route::middleware(['auth:remitente', 'licencia.activa'])->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});


//exportar excel - gomez
Route::get(
    '/sadmin/empresas/export-csv',
    [EmpresaController::class, 'exportCsv']
)->name('empresas.export.csv');

// ================= RECUPERACIÓN DE CONTRASEÑA =================-Gomez

use App\Http\Controllers\Auth\EmpleadoPasswordController;

Route::prefix('empleado')->group(function () {

    Route::get('forgot-password', [EmpleadoPasswordController::class, 'showForgotForm'])
        ->name('empleado.password.forgot');

    Route::post('send-code', [EmpleadoPasswordController::class, 'sendCode'])
        ->name('empleado.password.send');

    Route::get('verify-code', [EmpleadoPasswordController::class, 'showVerifyForm'])
        ->name('empleado.password.verify');

    Route::post('reset-password', [EmpleadoPasswordController::class, 'resetPassword'])
        ->name('empleado.password.reset');
});

// Exportar pagos a PDF y Excel - Gomez
Route::get('/sadmin/admins/export/pdf', [UsuarioController::class, 'exportPdf'])
    ->name('sadmin.export.pdf');

Route::get('/sadmin/admins/export/excel', [UsuarioController::class, 'exportExcel'])
    ->name('sadmin.export.excel');


// EXPORTAR PLANES

Route::get('/sadmin/planes/export/pdf', [PlanController::class, 'exportPdf'])
    ->name('planes.export.pdf');


Route::get('/sadmin/planes/export/excel', [PlanController::class, 'exportExcel'])
    ->name('planes.export.excel');

// EXPORTAR EMPRESAS


Route::get('/sadmin/empresas/export/pdf', [EmpresaController::class, 'exportPdf'])
    ->name('empresas.export.pdf');

Route::get('/sadmin/empresas/export/excel', [EmpresaController::class, 'exportExcel'])
    ->name('empresas.export.excel');

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('web.index');
