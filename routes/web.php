<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\EmpleadoPasswordController;

// Public
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Public\CorrespondenciaExternaController;

// Sadmin
use App\Http\Controllers\Sadmin\DashboardController as SadminDashboardController;
use App\Http\Controllers\Sadmin\UsuarioController as SadminUsuarioController;
use App\Http\Controllers\Sadmin\EmpresaController as SadminEmpresaController;
use App\Http\Controllers\Sadmin\LicenciaController as SadminLicenciaController;
use App\Http\Controllers\Sadmin\PagoController as SadminPagoController;
use App\Http\Controllers\Sadmin\PlanController as SadminPlanController;

// Admin
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PagoController as AdminPagoController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DepartamentoController;
use App\Http\Controllers\Admin\CiudadController;
use App\Http\Controllers\Admin\PrioridadController;
use App\Http\Controllers\Admin\TipoController;
use App\Http\Controllers\Admin\EstadoController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\RadicadoController;
use App\Http\Controllers\Admin\UsuarioController as AdminUsuarioController;
use App\Http\Controllers\Admin\ReporteController as AdminReporteController;
use App\Http\Controllers\Admin\AdminCorrespondenciaController;

// Empleado
use App\Http\Controllers\Empleado\HomeController as EmpleadoHomeController;
use App\Http\Controllers\Empleado\CorrespondenciaController as EmpleadoCorrespondenciaController;
use App\Http\Controllers\Empleado\ReporteController as EmpleadoReporteController;

// Remitente
use App\Http\Controllers\Remitente\DashboardController as RemitenteDashboardController;
use App\Http\Controllers\Remitente\ExternarecController;
use App\Http\Controllers\Remitente\ExternaenvController;

// Exports & Utils
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagosExport;
use App\Exports\LicenciasExport;


// ================= PUBLIC ROUTES =================
Route::get('/', [LandingController::class, 'index'])->name('web.index');

// Páginas informativas
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

// ================= AUTH ROUTES =================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/2fa', [TwoFactorController::class, 'showTwoFactorForm'])->name('2fa.index');
Route::post('/2fa', [TwoFactorController::class, 'verifyTwoFactor'])->name('2fa.verify');

Route::prefix('empleado')->group(function () {
    Route::get('forgot-password', [EmpleadoPasswordController::class, 'showForgotForm'])->name('empleado.password.forgot');
    Route::post('send-code', [EmpleadoPasswordController::class, 'sendCode'])->name('empleado.password.send');
    Route::get('verify-code', [EmpleadoPasswordController::class, 'showVerifyForm'])->name('empleado.password.verify');
    Route::post('reset-password', [EmpleadoPasswordController::class, 'resetPassword'])->name('empleado.password.reset');
});

// ================= PÚBLICO: CORRESPONDENCIA EXTERNA =================
Route::prefix('correspondencia')->name('public.correspondencia.')->group(function () {
    Route::get('/enviar', [CorrespondenciaExternaController::class, 'create'])->name('enviar');
    Route::post('/enviar', [CorrespondenciaExternaController::class, 'store'])->name('store')->middleware('throttle:5,1');
    Route::get('/consultar', [CorrespondenciaExternaController::class, 'consultar'])->name('consultar');
    Route::post('/buscar', [CorrespondenciaExternaController::class, 'buscarRadicado'])->name('buscar');
});

// ================= SADMIN (Rol: 1) =================
Route::prefix('sadmin')->middleware(['auth:web', 'role:1'])->group(function () {
    Route::get('/', [SadminDashboardController::class, 'index'])->name('sadmin.dashboard');
    Route::get('/index', [SadminDashboardController::class, 'index'])->name('sadmin.index');

    // Pagos
    Route::get('/pagos', [SadminPagoController::class, 'index'])->name('sadmin.pagos');
    Route::post('/pagos/{id}/aprobar', [SadminPagoController::class, 'aprobar'])->name('sadmin.pagos.aprobar');
    Route::post('/pagos/{id}/denegar', [SadminPagoController::class, 'denegar'])->name('sadmin.pagos.denegar');
    Route::get('/pagos/export/excel', function () { return Excel::download(new PagosExport, 'pagos.xlsx'); })->name('sadmin.pagos.export.excel');
    Route::get('/pagos/export/pdf', function () {
        $pagos = \App\Models\Pago::with(['plan', 'estado'])->get();
        return Pdf::loadView('sadmin.pdf.pagos_pdf', compact('pagos'))->download('pagos.pdf');
    })->name('sadmin.pagos.export.pdf');

    // Licencias
    Route::get('/licencias', [SadminLicenciaController::class, 'index'])->name('sadmin.licencias');
    Route::post('/licencias', [SadminLicenciaController::class, 'store'])->name('sadmin.licencias.store');
    Route::post('/licencias/{id}/toggle', [SadminLicenciaController::class, 'toggle'])->name('sadmin.licencias.toggle');
    Route::get('/licencias/export/excel', function () { return Excel::download(new LicenciasExport, 'licencias.xlsx'); })->name('sadmin.licencias.export.excel');
    Route::get('/licencias/export/pdf', function () { return Pdf::loadView('sadmin.pdf.licencias_pdf')->download('licencias.pdf'); })->name('sadmin.licencias.export.pdf');

    // Planes
    Route::get('/planes', [SadminPlanController::class, 'index'])->name('cplanes');
    Route::post('/planes', [SadminPlanController::class, 'store'])->name('planes.store');
    Route::put('/planes/{id}', [SadminPlanController::class, 'update'])->name('planes.update');
    Route::delete('/planes/{id}', [SadminPlanController::class, 'destroy'])->name('planes.destroy');
    Route::get('/planes/export/pdf', [SadminPlanController::class, 'exportPdf'])->name('planes.export.pdf');
    Route::get('/planes/export/excel', [SadminPlanController::class, 'exportExcel'])->name('planes.export.excel');

    // Empresas
    Route::get('/empresas', [SadminEmpresaController::class, 'index'])->name('empresas');
    Route::post('/empresas', [SadminEmpresaController::class, 'store'])->name('empresas.store');
    Route::put('/empresas/{nit}', [SadminEmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{nit}', [SadminEmpresaController::class, 'destroy'])->name('empresas.destroy');
    Route::get('/empresas/export/pdf', [SadminEmpresaController::class, 'exportPdf'])->name('empresas.export.pdf');
    Route::get('/empresas/export/excel', [SadminEmpresaController::class, 'exportExcel'])->name('empresas.export.excel');
    Route::get('/empresas/export-csv', [SadminEmpresaController::class, 'exportCsv'])->name('empresas.export.csv');

    // Admins
    Route::get('/admins', [SadminUsuarioController::class, 'index'])->name('admins');
    Route::post('/admins', [SadminUsuarioController::class, 'store'])->name('admins.store');
    Route::put('/admins/{emple_doc}', [SadminUsuarioController::class, 'update'])->name('admins.update');
    Route::get('/admins/export/pdf', [SadminUsuarioController::class, 'exportPdf'])->name('sadmin.export.pdf');
    Route::get('/admins/export/excel', [SadminUsuarioController::class, 'exportExcel'])->name('sadmin.export.excel');
});

// ================= ADMIN (Rol: 2) =================
Route::prefix('admin')->middleware(['auth:web', 'licencia.activa', 'role:2'])->name('admin.')->group(function () {

    Route::get('/', [AdminUsuarioController::class, 'index'])->name('index');
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home');
    Route::get('/reportes', [AdminReporteController::class, 'index'])->name('reportes');
    Route::post('/reportes/export/pdf', [AdminReporteController::class, 'exportPdf'])->name('reportes.export.pdf');
    Route::get('/otros', function () { return view('admin.otros'); })->name('otros');

    // Planes & Pagos
    Route::get('/planes', [AdminPlanController::class, 'index'])->name('planes');
    Route::get('/pagos/{plan}', [AdminPagoController::class, 'index'])->name('pagos.index');
    Route::post('/pagos', [AdminPagoController::class, 'store'])->name('pagos.store'); // Not prefixed name correctly in original, left as is: pagos.store
    Route::get('/historialp', [AdminPagoController::class, 'historial'])->name('historialp');

    // Exports de Pagos huérfanados
    Route::get('/pagos/export/excel', function () { return Excel::download(new PagosExport, 'pagos.xlsx'); })->name('pagos.export.excel');
    Route::get('/pagos/export/pdf', function () {
        $pagos = \App\Models\Pago::with(['plan', 'estado'])->get();
        return Pdf::loadView('admin.pdf.pagos_pdf', compact('pagos'))->setPaper('A4', 'landscape')->download('pagos.pdf');
    })->name('pagos.export.pdf');

    // Correspondencia
    Route::get('/correspondencia', [AdminCorrespondenciaController::class, 'index'])->name('correspondencia');
    Route::get('/correspondencia/export/excel', [AdminCorrespondenciaController::class, 'exportExcel'])->name('correspondencia.export.excel');
    Route::get('/correspondencia/export/pdf', [AdminCorrespondenciaController::class, 'exportPdf'])->name('correspondencia.export.pdf');
    Route::get('/correspondencia/interna/{id}/historial', [AdminCorrespondenciaController::class, 'historialInterna'])->name('correspondencia.historial_interna');
    Route::get('/correspondencia/externa/{id}/historial', [AdminCorrespondenciaController::class, 'historialExterna'])->name('correspondencia.historial_externa');

    // Usuarios (Empleados y Remitentes)
    Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios');
    Route::post('/usuarios/empleado', [AdminUsuarioController::class, 'storeEmpleado'])->name('empleado.store');
    Route::put('/usuarios/empleado/{emple_doc}', [AdminUsuarioController::class, 'updateEmpleado'])->name('empleado.update');
    Route::post('/usuarios/remitente', [AdminUsuarioController::class, 'storeRemitente'])->name('remitente.store');
    Route::put('/usuarios/remitente/{rem_doc}', [AdminUsuarioController::class, 'updateRemitente'])->name('remitente.update');

    // Configuraciones Varias (Areas, Departamentos, Ciudades, Prioridad, Tipo, Estado, Rol, Radicados)
    Route::resource('/areas', AreaController::class)->only(['index', 'store', 'update'])->names('area');
    Route::get('/areas/export/excel', [AreaController::class, 'exportExcel'])->name('areas.export.excel');
    Route::get('/areas/export/pdf', [AreaController::class, 'exportPdf'])->name('areas.export.pdf');

    Route::resource('/departamento', DepartamentoController::class)->only(['index', 'store', 'update'])->names('departamento');
    Route::get('/departamento/export/pdf', [DepartamentoController::class, 'exportPdf'])->name('departamento.export.pdf');
    Route::get('/departamento/export/excel', [DepartamentoController::class, 'exportExcel'])->name('departamento.export.excel');
    Route::get('/departamento/check-codigo', [DepartamentoController::class, 'checkCodigo'])->name('departamento.check');

    Route::resource('/ciudad', CiudadController::class)->only(['index', 'store', 'update'])->names('ciudad');
    Route::get('/ciudad/export/pdf', [CiudadController::class, 'exportPDF'])->name('ciudad.export.pdf');
    Route::get('/ciudad/export/excel', [CiudadController::class, 'exportExcel'])->name('ciudad.export.excel');
    Route::get('/ciudad/check-codigo', [CiudadController::class, 'checkCodigo'])->name('ciudad.check');

    Route::resource('/prioridad', PrioridadController::class)->only(['index', 'store', 'update'])->names('prioridad');
    Route::get('/prioridad/export/excel', [PrioridadController::class, 'exportExcel'])->name('prioridad.export.excel');
    Route::get('/prioridad/export/pdf', [PrioridadController::class, 'exportPdf'])->name('prioridad.export.pdf');
    Route::get('/prioridad/check', [PrioridadController::class, 'check'])->name('prioridad.check');

    Route::resource('/tipo', TipoController::class)->only(['index', 'store', 'update'])->names('tipo');
    Route::get('/tipo/export/excel', [TipoController::class, 'exportExcel'])->name('tipo.export.excel');
    Route::get('/tipo/export/pdf', [TipoController::class, 'exportPdf'])->name('tipo.export.pdf');
    Route::get('/tipo/check', [TipoController::class, 'check'])->name('tipo.check');

    Route::resource('/estado', EstadoController::class)->only(['index', 'store', 'update'])->names('estado');
    Route::get('/estado/export/excel', [EstadoController::class, 'exportExcel'])->name('estado.export.excel');
    Route::get('/estado/export/pdf', [EstadoController::class, 'exportPdf'])->name('estado.export.pdf');
    Route::get('/estado/check', [EstadoController::class, 'check'])->name('estado.check');

    Route::resource('/rol', RolController::class)->only(['index', 'store', 'update'])->names('rol');
    Route::get('/rol/export/excel', [RolController::class, 'exportExcel'])->name('rol.export.excel');
    Route::get('/rol/export/pdf', [RolController::class, 'exportPdf'])->name('rol.export.pdf');
    Route::get('/rol/check', [RolController::class, 'check'])->name('rol.check');

    Route::resource('/radicados', RadicadoController::class)->only(['index', 'store', 'update'])->names('radicado');
    Route::get('/radicados/check', [RadicadoController::class, 'check'])->name('radicado.check');
    Route::get('/radicados/export/excel', [RadicadoController::class, 'exportExcel'])->name('radicado.export.excel');
    Route::get('/radicados/export/pdf', [RadicadoController::class, 'exportPdf'])->name('radicado.export.pdf');
});

// Arreglo para nombres que originalmente no llevaban "admin." en auth:web
Route::post('admin/pagos', [AdminPagoController::class, 'store'])->name('pagos.store')->middleware(['auth:web', 'licencia.activa', 'role:2']);

// ================= EMPLEADOS (Cualquier rol web autenticado) =================
Route::middleware(['auth:web', 'licencia.activa'])->group(function () {
    // Perfil / Ajustes de cuenta (Compartido)
    Route::post('/perfil/actualizar', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/perfil/actualizar-password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.update_password');
});

Route::prefix('empleado')->middleware(['auth:web', 'licencia.activa'])->name('empleado.')->group(function () {
    Route::get('/', [EmpleadoHomeController::class, 'index'])->name('index');
    Route::post('/notificacion/{type}/{id}/visto', [EmpleadoHomeController::class, 'markAsRead'])->name('notificacion_visto');
    
    Route::get('/correspondencia-recibida', [EmpleadoCorrespondenciaController::class, 'recibida'])->name('correspondencia_recibida');
    Route::get('/correspondencia-finalizada', [EmpleadoCorrespondenciaController::class, 'finalizada'])->name('correspondencia_finalizada');
    Route::post('/correspondencia-recibida/{id}/estado', [EmpleadoCorrespondenciaController::class, 'actualizarEstado'])->name('estado_externa');
    Route::post('/correspondencia-interna/{id}/estado', [EmpleadoCorrespondenciaController::class, 'actualizarEstadoInterna'])->name('estado_interna');
    Route::post('/correspondencia-recibida/{id}/reasignar', [EmpleadoCorrespondenciaController::class, 'reasignar'])->name('reasignar_externa');
    Route::post('/correspondencia-interna/nueva', [EmpleadoCorrespondenciaController::class, 'nuevaInterna'])->name('nueva_interna');
    Route::post('/correspondencia-ventanilla/nueva', [EmpleadoCorrespondenciaController::class, 'nuevaVentanilla'])->name('nueva_ventanilla');
    Route::post('/correspondencia-interna/gestionar-rechazo', [EmpleadoCorrespondenciaController::class, 'gestionarRechazoInterno'])->name('gestionar_rechazo_interna');
    Route::get('/correspondencia-interna/{id}/historial', [EmpleadoCorrespondenciaController::class, 'historialInterna'])->name('historial_interna');
    Route::get('/envios-internos', [EmpleadoCorrespondenciaController::class, 'enviosInternos'])->name('envios_internos');
    
    Route::get('/reportes', [EmpleadoReporteController::class, 'index'])->name('reportes');
    Route::get('/reportes/export/pdf', [EmpleadoReporteController::class, 'exportPdf'])->name('reportes.export.pdf');
});


// ================= REMITENTE =================
Route::prefix('remitente')->middleware(['auth:remitente', 'licencia.activa'])->name('remitente.')->group(function () {
    Route::get('/', [RemitenteDashboardController::class, 'index'])->name('index');
    
    // Antiguas y actuales vistas y modulos
    Route::get('/interna', function () { return view('remitente.interna'); })->name('interna');
    Route::get('/externarec', [ExternarecController::class, 'index'])->name('externarec');
    Route::get('/externaenv', [ExternaenvController::class, 'index'])->name('externaenv');
    Route::get('/externaenv/{id}/history', [ExternaenvController::class, 'getHistory'])->name('externaenv.history');
    Route::post('/externaenv', [ExternaenvController::class, 'store'])->name('externaenv.store');

    Route::post('/externarec', [ExternarecController::class, 'store'])->name('externarec.store'); // Not named remitente.externarec.store to respect original
    Route::post('/externarec/{id}/asignar', [ExternarecController::class, 'asignarDestinatarios'])->name('externarec.asignar');
    Route::post('/externarec/{id}/rechazar', [ExternarecController::class, 'rechazar'])->name('externarec.rechazar');
    Route::get('/externarec/{id}/archivos', [ExternarecController::class, 'getArchivos'])->name('externarec.archivos');

    Route::get('/empleados/buscar', [ExternaenvController::class, 'buscarEmpleados'])->name('buscar_empleados');
    Route::get('/ciudades/buscar', [ExternarecController::class, 'buscarCiudades'])->name('externarec.ciudades.buscar');

    // Dashboard actions
    Route::get('/recibidos', [RemitenteDashboardController::class, 'recibidosProceso'])->name('recibidos');
    Route::get('/proceso-salientes', [RemitenteDashboardController::class, 'procesoSalientes'])->name('salientes');
    Route::get('/finalizados', [RemitenteDashboardController::class, 'finalizados'])->name('finalizados');
    Route::get('/history/{id}', [RemitenteDashboardController::class, 'getHistory'])->name('history');
    Route::post('/{id}/finalize', [RemitenteDashboardController::class, 'finalize'])->name('finalize');
    Route::post('/{id}/store-saliente', [RemitenteDashboardController::class, 'storeSalienteFromResponse'])->name('store_saliente');
    Route::post('/envio/{id}/store-saliente', [RemitenteDashboardController::class, 'storeSalienteFromEnvio'])->name('store_saliente_envio');
    Route::post('/{id}/update-rejected', [RemitenteDashboardController::class, 'updateRejected'])->name('update_rejected');
});

// Original legacy names that lacked prefixes but were highly linked
Route::post('remitente/externarec', [ExternarecController::class, 'store'])->name('externarec.store')->middleware(['auth:remitente', 'licencia.activa']);
Route::post('remitente/externarec/{id}/asignar', [ExternarecController::class, 'asignarDestinatarios'])->name('externarec.asignar')->middleware(['auth:remitente', 'licencia.activa']);
Route::post('remitente/externarec/{id}/rechazar', [ExternarecController::class, 'rechazar'])->name('externarec.rechazar')->middleware(['auth:remitente', 'licencia.activa']);
Route::get('remitente/ciudades/buscar', [ExternarecController::class, 'buscarCiudades'])->name('externarec.ciudades.buscar')->middleware(['auth:remitente', 'licencia.activa']);
Route::get('remitente/externarec/{id}/archivos', [ExternarecController::class, 'getArchivos'])->name('externarec.archivos')->middleware(['auth:remitente', 'licencia.activa']);
