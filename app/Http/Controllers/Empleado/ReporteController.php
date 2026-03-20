<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleEnvio;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Display a dashboard with real, non-duplicated statistics for the Employee.
     * We filter the 'detalle_envio' table to find only the MAX(id_detalle)
     * for every id_envio assigned to the current employee, ensuring
     * each document is only counted in its current, latest state.
     */
    public function index(Request $request)
    {
        $mes = $request->query('mes', date('Y-m'));
        $rango = $request->query('rango', 'mes');
        $data = $this->getReportData($mes, $rango);
        return view('empleado.reportes', $data);
    }

    public function exportPdf(Request $request)
    {
        $mes = $request->query('mes', date('Y-m'));
        $rango = $request->query('rango', 'mes');
        $data = $this->getReportData($mes, $rango);
        
        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Recibidos', 'En Trámite', 'Finalizados', 'Rechazados', 'Archivados', 'Vencidos'],
                'datasets' => [[
                    'label' => '',
                    'data' => [$data['countRecibido'], $data['countTramite'], $data['countFinalizado'], $data['countRechazado'], $data['countArchivado'], $data['countVencidos']],
                    'backgroundColor' => ['#3b82f6', '#eab308', '#22c55e', '#ef4444', '#64748b', '#f97316']
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => false],
                    'datalabels' => [
                        'display' => true,
                        'align' => 'end',
                        'anchor' => 'end'
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => ['stepSize' => 1]
                    ]
                ]
            ]
        ];

        $chartUrl = 'https://quickchart.io/chart?v=3&c=' . urlencode(json_encode($chartConfig)) . '&w=600&h=300';
        $chartImage = '';
        try {
            $ctx = stream_context_create(['http' => ['timeout' => 5]]);
            $imageData = file_get_contents($chartUrl, false, $ctx);
            if ($imageData) {
                $chartImage = 'data:image/png;base64,' . base64_encode($imageData);
            }
        } catch (\Exception $e) {
            // Falla de forma segura
        }

        $data['chartImage'] = $chartImage;

        $pdf = Pdf::loadView('empleado.pdf.reportes_pdf', $data)
            ->setPaper('A4', 'portrait');
            
        return $pdf->download("REPORTE_METRICAS_" . strtoupper($mes . '_' . $rango) . ".pdf");
    }

    private function getReportData($mes, $rango)
    {
        $user = Auth::user();
        $now = Carbon::now();

        try {
            $baseDate = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
            // Validación: No permitir meses futuros
            if ($baseDate->isFuture()) {
                $baseDate = Carbon::now()->startOfMonth();
                $mes = $baseDate->format('Y-m');
            }
        } catch (\Exception $e) {
            // Fallback si la fecha enviada es inválida
            $baseDate = Carbon::now()->startOfMonth();
            $mes = $baseDate->format('Y-m');
        }

        // Determinar rango de fechas
        if ($rango === 'mes') {
            $start = $baseDate->copy()->startOfMonth();
            $end = $baseDate->copy()->endOfMonth();
        } elseif ($rango === 'trimestre') {
            $start = $baseDate->copy()->subMonths(2)->startOfMonth();
            $end = $baseDate->copy()->endOfMonth();
        } elseif ($rango === 'anio') {
            $start = $baseDate->copy()->startOfYear();
            $end = $baseDate->copy()->endOfYear();
        } else {
            $start = $baseDate->copy()->startOfMonth();
            $end = $baseDate->copy()->endOfMonth();
        }

        $latestDetalleSubquery = DetalleEnvio::select(DB::raw('MAX(id_detalle) as id_detalle'))
            ->where('id_quien_recibe', $user->emple_doc)
            ->whereBetween('fecha_traslado', [$start, $end])
            ->groupBy('id_envio');

        $totales = DetalleEnvio::with(['estado', 'envio.tipoEnvio'])
            ->whereIn('id_detalle', $latestDetalleSubquery)
            ->where('id_quien_recibe', $user->emple_doc)
            ->get();

        $countRecibido = 0;
        $countTramite = 0;
        $countFinalizado = 0;
        $countArchivado = 0;
        $countRechazado = 0;
        $countVencidos = 0;

        foreach ($totales as $detalle) {
            $estadoNomb = strtolower($detalle->estado->estado_nomb ?? '');

            $isActive = false;

            if (str_contains($estadoNomb, 'recibido')) {
                $countRecibido++;
                $isActive = true;
            } elseif (str_contains($estadoNomb, 'tramit') || str_contains($estadoNomb, 'trámit')) {
                $countTramite++;
                $isActive = true;
            } elseif (str_contains($estadoNomb, 'finalizado') || str_contains($estadoNomb, 'resuelto')) {
                $countFinalizado++;
            } elseif (str_contains($estadoNomb, 'archivado')) {
                $countArchivado++;
            } elseif (str_contains($estadoNomb, 'rechazado')) {
                $countRechazado++;
            }

            if ($isActive && $detalle->envio && $detalle->envio->tipoEnvio && $detalle->envio->tipoEnvio->dias_respuesta) {
                $fechaEnvio = Carbon::parse($detalle->envio->fecha);
                $limite = $fechaEnvio->copy()->addDays($detalle->envio->tipoEnvio->dias_respuesta);
                if ($now->greaterThan($limite)) {
                    $countVencidos++;
                }
            }
        }

        $totalUnicos = $totales->count();

        return [
            'countRecibido' => $countRecibido,
            'countTramite' => $countTramite,
            'countFinalizado' => $countFinalizado,
            'countArchivado' => $countArchivado,
            'countRechazado' => $countRechazado,
            'countVencidos' => $countVencidos,
            'totalUnicos' => $totalUnicos,
            'mesSelect' => $mes,
            'rangoSelect' => $rango,
            'rangoFechas' => ucfirst($start->translatedFormat('1 F Y')) . " - " . ucfirst($end->translatedFormat('t F Y'))
        ];
    }
}
