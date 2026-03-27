<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Pago;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanesExport;


class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.planes', compact('plans'));
    }
    public function exportPdf()
    {
        $planes = Plan::all();

        $pdf = Pdf::loadView('sadmin.pdf.planes_pdf', compact('planes'));

        return $pdf->download('planes_sistema.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PlanesExport, 'planes_sistema.xlsx');
    }

}
