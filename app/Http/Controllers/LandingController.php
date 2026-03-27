<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $planes = Plan::orderBy('valor')->get();
        return view('web.index', compact('planes')); 
    }
}
