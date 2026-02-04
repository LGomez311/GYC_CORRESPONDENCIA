<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = Empleado::with(['rol', 'estado'])->get();

        return view('sadmin.cusers', compact('users'));

        $users = Empleado::with(['rol', 'estado'])->get();

        return view('sadmin.cusers', compact('users'));
    }
}
