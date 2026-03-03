<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Remitente;

class UsuarioController extends Controller
{
    public function index()
    {
        // Obtener el NIT de la empresa del admin logeado
        $nitEmpresa = auth()->user()->nit_empresa;

        // Traer Empleados de la empresa, filtrando los SuperAdmin (id_rol = 1)
        $empleados = Empleado::with(['rol', 'estado', 'area', 'empresa'])
            ->where('emple_rol', '!=', 1)
            ->where('nit_empresa', $nitEmpresa)
            ->get();
        
        // Traer Remitentes asociados a la misma empresa
        $remitentes = Remitente::with(['ciudad', 'empresa'])
            ->where('nit_empresa', $nitEmpresa)
            ->get();

        // Calcular estadísticas para la empresa actual (excluyendo SuperAdmin)
        $stats = [
            'total' => Empleado::where('emple_rol', '!=', 1)->where('nit_empresa', $nitEmpresa)->count() + Remitente::where('nit_empresa', $nitEmpresa)->count(),
            'activos' => Empleado::where('emple_rol', '!=', 1)->where('emple_estado', 1)->where('nit_empresa', $nitEmpresa)->count() + Remitente::where('rem_estado', 1)->where('nit_empresa', $nitEmpresa)->count(),
            'inactivos' => Empleado::where('emple_rol', '!=', 1)->where('emple_estado', 2)->where('nit_empresa', $nitEmpresa)->count() + Remitente::where('rem_estado', 2)->where('nit_empresa', $nitEmpresa)->count(),
            'nuevos' => 0,
        ];

        return view('admin.usuarios', compact('empleados', 'remitentes', 'stats'));
    }
}
