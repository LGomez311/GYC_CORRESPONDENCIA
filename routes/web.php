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
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\PrioridadController;
use App\Http\Controllers\Admin\TipoController;
use App\Http\Controllers\Admin\EstadoController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\RadicadoController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;



// Alias para controllers con nombres iguales
use App\Http\Controllers\Sadmin\PagoController as SadminPagoController;
use App\Http\Controllers\Admin\PagoController as AdminPagoController;

use App\Http\Controllers\Sadmin\PlanController as SadminPlanController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Exports\PrioridadesExport;

// controller de remitente
use App\Http\Controllers\Remitente\ExternarecController;


Route::get('/', [LandingController::class, 'index'])->name('web.index');



// Ruta de exportar excel con datos
Route::get('/admin/pagos/export/excel', function () {
    return Excel::download(new PagosExport, 'pagos.xlsx');
})->name('pagos.export.excel')->middleware(['auth:web', 'licencia.activa', 'role:2']);

// Ruta para exportar pdf con datos
Route::get('/admin/pagos/export/pdf', function () {

    $pagos = Pago::with(['plan', 'estado'])->get();

    $pdf = Pdf::loadView('admin.pdf.pagos_pdf', compact('pagos'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('pagos.pdf');
})->name('pagos.export.pdf')->middleware(['auth:web', 'licencia.activa', 'role:2']);
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
    Route::get('/superadmin', [\App\Http\Controllers\Sadmin\DashboardController::class, 'index'])->name('sadmin.index');

    // Admin
    Route::get('/admin', fn() => view('admin.index'))->name('admin.index');

    // Empleado
    Route::get('/empleado', fn() => view('empleado.index'))->name('empleado.index');
    Route::get('/empleado/correspondencia-recibida', [\App\Http\Controllers\Empleado\CorrespondenciaController::class, 'recibida'])->name('empleado.correspondencia_recibida');
    Route::post('/empleado/correspondencia-recibida/{id}/estado', [\App\Http\Controllers\Empleado\CorrespondenciaController::class, 'actualizarEstado'])->name('empleado.estado_externa');
    Route::post('/empleado/correspondencia-interna/{id}/estado', [\App\Http\Controllers\Empleado\CorrespondenciaController::class, 'actualizarEstadoInterna'])->name('empleado.estado_interna');
    Route::post('/empleado/correspondencia-recibida/{id}/reasignar', [\App\Http\Controllers\Empleado\CorrespondenciaController::class, 'reasignar'])->name('empleado.reasignar_externa');
    Route::post('/empleado/correspondencia-interna/nueva', [\App\Http\Controllers\Empleado\CorrespondenciaController::class, 'nuevaInterna'])->name('empleado.nueva_interna');
    Route::get('/empleado/reportes', [\App\Http\Controllers\Empleado\ReporteController::class, 'index'])->name('empleado.reportes');
});


Route::prefix('sadmin')
    ->middleware(['auth:web', 'role:1'])
    ->group(function () {

        // Dashboard
        Route::get('/', [\App\Http\Controllers\Sadmin\DashboardController::class, 'index'])->name('sadmin.dashboard');

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
    ->middleware(['auth:web', 'licencia.activa', 'role:2'])
    ->group(function () {

        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\UsuarioController::class, 'index'])->name('admin.index');
        Route::get('/home', [AdminHomeController::class, 'index'])->name('admin.home');

        // Planes
        Route::get('/planes', [AdminPlanController::class, 'index'])->name('admin.planes');

        // Pagos

        Route::get('/pagos/{plan}', [AdminPagoController::class, 'index'])->name('admin.pagos.index');
        Route::post('/pagos', [AdminPagoController::class, 'store'])->name('pagos.store');

        Route::get('/historialp', [AdminPagoController::class, 'historial'])->name('admin.historialp');

        // Otros recursos del admin
        Route::get('/correspondencia', [\App\Http\Controllers\Admin\AdminCorrespondenciaController::class, 'index'])->name('admin.correspondencia');
        Route::get('/correspondencia/export/excel', [\App\Http\Controllers\Admin\AdminCorrespondenciaController::class, 'exportExcel'])->name('admin.correspondencia.export.excel');
        Route::get('/correspondencia/export/pdf', [\App\Http\Controllers\Admin\AdminCorrespondenciaController::class, 'exportPdf'])->name('admin.correspondencia.export.pdf');

        
        // Perfil / Ajustes de cuenta
        Route::post('/perfil/actualizar', [\App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/perfil/enviar-codigo', [\App\Http\Controllers\Admin\ProfileController::class, 'sendVerificationCode'])->name('admin.profile.send_code');
        Route::post('/perfil/actualizar-password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('admin.profile.update_password');


        // Usuarios (Empleados y Remitentes)
        Route::get('/usuarios', [\App\Http\Controllers\Admin\UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::post('/usuarios/empleado', [\App\Http\Controllers\Admin\UsuarioController::class, 'storeEmpleado'])->name('admin.empleado.store');
        Route::put('/usuarios/empleado/{emple_doc}', [\App\Http\Controllers\Admin\UsuarioController::class, 'updateEmpleado'])->name('admin.empleado.update');
        Route::post('/usuarios/remitente', [\App\Http\Controllers\Admin\UsuarioController::class, 'storeRemitente'])->name('admin.remitente.store');
        Route::put('/usuarios/remitente/{rem_doc}', [\App\Http\Controllers\Admin\UsuarioController::class, 'updateRemitente'])->name('admin.remitente.update');



        // Prioridades (CRUD + export)
        Route::get('/prioridad', [PrioridadController::class, 'index'])->name('admin.prioridad.index');
        Route::post('/prioridad', [PrioridadController::class, 'store'])->name('admin.prioridad.store');
        Route::put('/prioridad/{id}', [PrioridadController::class, 'update'])->name('admin.prioridad.update');

        Route::get('/prioridad/export/excel', [PrioridadController::class, 'exportExcel'])->name('admin.prioridad.export.excel');
        Route::get('/prioridad/export/pdf', [PrioridadController::class, 'exportPdf'])->name('admin.prioridad.export.pdf');
        Route::get('/prioridad/check', [PrioridadController::class, 'check'])->name('admin.prioridad.check');

        // Tipos (CRUD + export)
        Route::get('/tipo', [TipoController::class, 'index'])->name('admin.tipo.index');
        Route::post('/tipo', [TipoController::class, 'store'])->name('admin.tipo.store');
        Route::put('/tipo/{id}', [TipoController::class, 'update'])->name('admin.tipo.update');

        Route::get('/tipo/export/excel', [TipoController::class, 'exportExcel'])->name('admin.tipo.export.excel');
        Route::get('/tipo/export/pdf', [TipoController::class, 'exportPdf'])->name('admin.tipo.export.pdf');
        Route::get('/tipo/check', [TipoController::class, 'check'])->name('admin.tipo.check');

        // Estados (mostrar desde id >= 6)
        Route::get('/estado', [EstadoController::class, 'index'])->name('admin.estado.index');
        Route::post('/estado', [EstadoController::class, 'store'])->name('admin.estado.store');
        Route::put('/estado/{id}', [EstadoController::class, 'update'])->name('admin.estado.update');

        Route::get('/estado/export/excel', [EstadoController::class, 'exportExcel'])->name('admin.estado.export.excel');
        Route::get('/estado/export/pdf', [EstadoController::class, 'exportPdf'])->name('admin.estado.export.pdf');
        Route::get('/estado/check', [EstadoController::class, 'check'])->name('admin.estado.check');

        // Roles (CRUD + export)
        Route::get('/rol', [RolController::class, 'index'])->name('admin.rol.index');
        Route::post('/rol', [RolController::class, 'store'])->name('admin.rol.store');
        Route::put('/rol/{id}', [RolController::class, 'update'])->name('admin.rol.update');

        Route::get('/rol/export/excel', [RolController::class, 'exportExcel'])->name('admin.rol.export.excel');
        Route::get('/rol/export/pdf', [RolController::class, 'exportPdf'])->name('admin.rol.export.pdf');
        Route::get('/rol/check', [RolController::class, 'check'])->name('admin.rol.check');

        // Radicados (CRUD)
        Route::get('/radicados', [RadicadoController::class, 'index'])->name('admin.radicado.index');
        Route::post('/radicados', [RadicadoController::class, 'store'])->name('admin.radicado.store');
        Route::put('/radicados/{id}', [RadicadoController::class, 'update'])->name('admin.radicado.update');
        Route::get('/radicados/check', [RadicadoController::class, 'check'])->name('admin.radicado.check');
        Route::get('/radicados/export/excel', [RadicadoController::class, 'exportExcel'])->name('admin.radicado.export.excel');
        Route::get('/radicados/export/pdf', [RadicadoController::class, 'exportPdf'])->name('admin.radicado.export.pdf');
    });

// Otros recursos del admin (duplicados eliminados)


// ruta para creacion de licencias - Kevin

Route::prefix('sadmin')->name('sadmin.')->middleware(['auth:web', 'role:1'])->group(function () {

    Route::get('/licencias', [LicenciaController::class, 'index'])
        ->name('licencias');

    Route::post('/licencias', [LicenciaController::class, 'store'])
        ->name('licencias.store');

    Route::post('/licencias/{id}/toggle', [LicenciaController::class, 'toggle'])
        ->name('licencias.toggle');
});



Route::middleware(['auth:remitente', 'licencia.activa'])->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});


//exportar excel - gomez
Route::get(
    '/sadmin/empresas/export-csv',
    [EmpresaController::class, 'exportCsv']
)->name('empresas.export.csv')->middleware(['auth:web', 'role:1']);

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
Route::middleware(['auth:web', 'role:1'])->group(function () {
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
});

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('web.index');


//Rutas para otros recursos del admin-Gomez 
Route::get('/admin/otros', [UsuarioController::class, 'otros'])
    ->name('admin.otros')->middleware(['auth:web', 'licencia.activa', 'role:2']);

//RUTAS CRUD AREA - GOMEZ

Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'licencia.activa', 'role:2'])->group(function () {
    Route::get('/areas', [AreaController::class, 'index'])->name('area.index');
    Route::post('/areas', [AreaController::class, 'store'])->name('area.store');
    Route::put('/areas/{id}', [AreaController::class, 'update'])->name('area.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'licencia.activa', 'role:2'])->group(function () {

    Route::get('/otros', function () {
        return view('admin.otros');
    })->name('otros');
});

//RUTAS CRUD DEPARTAMENTO - GOMEZ
use App\Http\Controllers\Admin\DepartamentoController;

Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'licencia.activa', 'role:2'])->group(function () {

    Route::get('/departamento', [DepartamentoController::class, 'index'])
        ->name('departamento.index');

    Route::post('/departamento', [DepartamentoController::class, 'store'])
        ->name('departamento.store');

    Route::put('/departamento/{id}', [DepartamentoController::class, 'update'])
        ->name('departamento.update');

    Route::get('/departamento/export/pdf', [DepartamentoController::class, 'exportPdf'])
        ->name('departamento.export.pdf');

    Route::get('/departamento/export/excel', [DepartamentoController::class, 'exportExcel'])
        ->name('departamento.export.excel');

    Route::get(
        'departamento/check-codigo',
        [DepartamentoController::class, 'checkCodigo']
    )->name('departamento.check');
});

// RUTAS PARA CRUD CIUDAD - GOMEZ
use App\Http\Controllers\Admin\CiudadController;

// RUTAS PARA EXPORTAR CIUDAD Y AREAS - GOMEZ
Route::middleware(['auth:web', 'licencia.activa', 'role:2'])->group(function () {
    Route::get('/admin/ciudad', [CiudadController::class, 'index'])->name('admin.ciudad.index');
    Route::post('/admin/ciudad', [CiudadController::class, 'store'])->name('admin.ciudad.store');
    Route::put('/admin/ciudad/{id}', [CiudadController::class, 'update'])->name('admin.ciudad.update');

    Route::get('/admin/ciudad/export/pdf', [CiudadController::class, 'exportPDF'])->name('admin.ciudad.export.pdf');
    Route::get('/admin/ciudad/export/excel', [CiudadController::class, 'exportExcel'])->name('admin.ciudad.export.excel');
    Route::get('/admin/ciudad/check-codigo', [CiudadController::class, 'checkCodigo'])->name('admin.ciudad.check');

    Route::get('/admin/areas/export/excel', [AreaController::class, 'exportExcel'])->name('admin.areas.export.excel');
    Route::get('/admin/areas/export/pdf', [AreaController::class, 'exportPdf'])->name('admin.areas.export.pdf');
});

// Vistas de web index publico
Route::view('/caracteristicas', 'web.pages.producto.caracteristicas')->name('caracteristicas');
Route::view('/seguridad', 'web.pages.producto.seguridad')->name('seguridad');
Route::view('/precios', 'web.pages.producto.precios')->name('precios');
Route::view('/mobile', 'web.pages.producto.mobile')->name('mobile');

Route::view('/sobre-nosotros', 'web.pages.empresa.sobre-nosotros')->name('sobre.nosotros');
Route::view('/clientes', 'web.pages.empresa.clientes')->name('clientes');
Route::view('/blog', 'web.pages.empresa.blog')->name('blog');
Route::view('/contacto', 'web.pages.empresa.contacto')->name('contacto');

Route::view('/privacidad', 'web.pages.legal.privacidad')->name('privacidad');
Route::view('/terminos', 'web.pages.legal.terminos')->name('terminos');
Route::view('/cookies', 'web.pages.legal.cookies')->name('cookies');

// Vistas remitente
Route::middleware(['auth:remitente', 'licencia.activa'])->group(function () {
    Route::get('/remitente', fn() => view('remitente.index'))->name('remitente.index');
});

Route::prefix('remitente')
    ->middleware(['auth:remitente', 'licencia.activa'])
    ->group(function () {

        Route::get('/interna', function () {
            return view('remitente.interna');
        })->name('remitente.interna');


        Route::get('/externarec', [ExternarecController::class, 'index'])->name('remitente.externarec');

        Route::get('/externaenv', function () {
            return view('remitente.externaenv');
        })->name('remitente.externaenv');

        Route::post('/externarec', [ExternarecController::class, 'store'])->name('externarec.store');

        Route::get('/empleados/buscar', [ExternarecController::class, 'buscarEmpleados'])->name('externarec.empleados.buscar');

        Route::get('/ciudades/buscar', [ExternarecController::class, 'buscarCiudades'])->name('externarec.ciudades.buscar');

        Route::get('/externarec/{id}/archivos', [ExternarecController::class, 'getArchivos'])->name('externarec.archivos');
    });

// ================= CORRESPONDENCIA EXTERNA PÚBLICA =================
use App\Http\Controllers\Public\CorrespondenciaExternaController;

// Aplicamos throttle para evitar spam (5 requests por minuto para POST)
Route::prefix('correspondencia')->name('public.correspondencia.')->group(function () {
    Route::get('/enviar', [CorrespondenciaExternaController::class, 'create'])->name('enviar');
    Route::post('/enviar', [CorrespondenciaExternaController::class, 'store'])->name('store')->middleware('throttle:5,1');
    
    Route::get('/consultar', [CorrespondenciaExternaController::class, 'consultar'])->name('consultar');
    Route::post('/buscar', [CorrespondenciaExternaController::class, 'buscarRadicado'])->name('buscar');
});
