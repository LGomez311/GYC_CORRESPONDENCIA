<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::all();
        return view('admin.planes', compact('planes'));
    }
}

