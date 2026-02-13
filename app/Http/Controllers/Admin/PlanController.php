<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Empresa;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.planes', compact('plans'));
    }

}
