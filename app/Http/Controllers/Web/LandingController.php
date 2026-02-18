<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class LandingController extends Controller
{
    public function index()
    {
        $planes = Plan::orderBy('valor')->get();

        return view('web.index', compact('planes'));
   
        return view('landing');
    }
}
