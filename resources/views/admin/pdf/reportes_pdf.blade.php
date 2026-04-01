<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Gestión Administrativa — G&C Correspondencia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 8.5px;
            color: #1e293b;
            background: #ffffff;
            padding: 25px 30px;
        }

        /* ===== HEADER ===== */
        .header {
            border-bottom: 2.5px solid #1d4ed8;
            padding-bottom: 12px;
            margin-bottom: 18px;
            width: 100%;
        }
        .header table { width: 100%; border: none; margin: 0; }
        .header td { border: none; padding: 0; vertical-align: bottom; }
        
        .header-left .title {
            font-size: 19px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .header-left .subtitle {
            font-size: 8px;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-top: 2px;
        }
        .header-right { text-align: right; }
        .header-right .date { font-size: 7.5px; color: #64748b; font-weight: bold; }
        .header-right .filter-badge {
            display: inline-block;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 2px 7px;
            border-radius: 15px;
            font-size: 7px;
            font-weight: bold;
            margin-top: 4px;
        }

        /* ===== SUMMARY CARDS ===== */
        .summary-wrapper { width: 100%; margin-bottom: 15px; }
        .summary-table { width: 100%; border-collapse: separate; border-spacing: 6px; border: none; }
        .summary-card {
            border-radius: 8px;
            padding: 10px 8px;
            text-align: center;
            border: 1px solid;
            width: 20%;
        }
        .card-blue   { background: #eff6ff; border-color: #bfdbfe; }
        .card-amber  { background: #fffbeb; border-color: #fde68a; }
        .card-green  { background: #f0fdf4; border-color: #bbf7d0; }
        .card-red    { background: #fff1f2; border-color: #fecdd3; }
        .card-indigo { background: #eef2ff; border-color: #c7d2fe; }

        .card-num { font-size: 18px; font-weight: bold; line-height: 1; display: block; }
        .card-blue .card-num   { color: #1d4ed8; }
        .card-amber .card-num  { color: #d97706; }
        .card-green .card-num  { color: #16a34a; }
        .card-red .card-num    { color: #dc2626; }
        .card-indigo .card-num { color: #4f46e5; }
        
        .card-label {
            display: block;
            font-size: 6px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 3px;
        }

        /* ===== CHARTS ===== */
        .charts-row { width: 100%; margin-bottom: 15px; display: table; border-collapse: separate; border-spacing: 10px; margin-left: -10px; }
        .chart-box {
            display: table-cell;
            width: 50%;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background: #fafafa;
            vertical-align: top;
        }
        .chart-box img { width: 100%; height: auto; max-height: 180px; }
        .chart-title { font-size: 7.5px; font-weight: bold; color: #475569; text-transform: uppercase; margin-bottom: 6px; }

        /* ===== TABLES ===== */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #334155;
            border-left: 3px solid #1d4ed8;
            padding-left: 7px;
            margin-bottom: 8px;
            margin-top: 14px;
        }

        table { width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0; margin-bottom: 12px; }
        thead tr { background: #0f172a; color: #fff; }
        th { padding: 7px 6px; font-size: 7px; text-transform: uppercase; font-weight: bold; text-align: center; }
        td { padding: 6px; border-bottom: 1px solid #f1f5f9; font-size: 8px; text-align: center; color: #334155; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .td-left { text-align: left; padding-left: 12px; font-weight: bold; color: #0f172a; }

        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 7px; font-weight: bold; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-red { background: #fee2e2; color: #991b1b; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 12px;
            left: 30px;
            right: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 6.5px;
            color: #94a3b8;
        }
        .pull-left { float: left; }
        .pull-right { float: right; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td class="header-left">
                    <div class="title">Reporte de Gestión</div>
                    <div class="subtitle">G&C Correspondencia · Panel Administrativo</div>
                </td>
                <td class="header-right">
                    <div class="date">Generado: {{ now()->format('d/m/Y H:i') }}</div>
                    <div class="filter-badge">{{ $filtroLabel }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary-wrapper">
        <table class="summary-table">
            <tr>
                <td class="summary-card card-blue">
                    <span class="card-num">{{ number_format($totalAsignados) }}</span>
                    <span class="card-label">Total Radicados</span>
                </td>
                <td class="summary-card card-amber">
                    <span class="card-num">{{ number_format($totalTramite) }}</span>
                    <span class="card-label">En Trámite</span>
                </td>
                <td class="summary-card card-green">
                    <span class="card-num">{{ number_format($totalFinalizado) }}</span>
                    <span class="card-label">Finalizados</span>
                </td>
                <td class="summary-card card-red">
                    <span class="card-num">{{ number_format($totalVencidos) }}</span>
                    <span class="card-label">Vencidos</span>
                </td>
                <td class="summary-card card-indigo">
                    <span class="card-num">{{ $eficienciaGlobal }}%</span>
                    <span class="card-label">Eficiencia Global</span>
                </td>
            </tr>
        </table>
    </div>

    @if((isset($barChart) && $barChart) || (isset($doughnutChart) && $doughnutChart))
    <div class="charts-row">
        @if(isset($barChart) && $barChart)
            <div class="chart-box">
                <div class="chart-title">Distribución por Área</div>
                <img src="{{ $barChart }}">
            </div>
        @endif
        @if(isset($doughnutChart) && $doughnutChart)
            <div class="chart-box">
                <div class="chart-title">Radar de Eficiencia</div>
                <img src="{{ $doughnutChart }}">
            </div>
        @endif
    </div>
    @endif

    <div class="section-title">Distribución por Naturaleza</div>
    @php $totalT = array_sum($resumenTipos); @endphp
    <table>
        <thead>
            <tr>
                <th style="text-align: left; padding-left: 12px;">Origen / Destino</th>
                <th>Volumen</th>
                <th>Participación</th>
                <th>Indicador</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="td-left">Correspondencia Interna</td>
                <td><strong>{{ $resumenTipos['Interna'] ?? 0 }}</strong></td>
                <td>{{ $totalT > 0 ? round(($resumenTipos['Interna'] / $totalT) * 100) : 0 }}%</td>
                <td><span class="badge badge-blue">INTERNA</span></td>
            </tr>
            <tr>
                <td class="td-left">Correspondencia Externa (Entrante)</td>
                <td><strong>{{ $resumenTipos['Externa'] ?? 0 }}</strong></td>
                <td>{{ $totalT > 0 ? round(($resumenTipos['Externa'] / $totalT) * 100) : 0 }}%</td>
                <td><span class="badge badge-green">EXTERNA</span></td>
            </tr>
            <tr>
                <td class="td-left">Correspondencia Saliente (Respuesta)</td>
                <td><strong>{{ $resumenTipos['Saliente'] ?? 0 }}</strong></td>
                <td>{{ $totalT > 0 ? round(($resumenTipos['Saliente'] / $totalT) * 100) : 0 }}%</td>
                <td><span class="badge badge-red">SALIENTE</span></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Métricas de Dependencias</div>
    <table>
        <thead>
            <tr>
                <th style="text-align: left; padding-left: 12px; width: 32%">Área / Dependencia</th>
                <th>Asignados</th>
                <th>Trámite</th>
                <th>Finalizado</th>
                <th>Vencidos</th>
                <th>Eficiencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporteAreas as $area)
                <tr>
                    <td class="td-left">{{ $area['area_nom'] }}</td>
                    <td style="font-weight: bold;">{{ $area['asignados'] }}</td>
                    <td style="color: #d97706;">{{ $area['tramite'] }}</td>
                    <td style="color: #16a34a; font-weight: bold;">{{ $area['finalizado'] }}</td>
                    <td style="{{ $area['vencidos'] > 0 ? 'color: #dc2626; font-weight: bold;' : 'color: #cbd5e1;' }}">
                        {{ $area['vencidos'] }}
                    </td>
                    <td>
                        <span style="font-weight: bold; color: #1d4ed8;">{{ $area['eficiencia'] }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <span class="pull-left">G&C Correspondencia · Sistema Inteligente de Gestión</span>
        <span class="pull-right">Página <span class="page-number"></span></span>
    </div>

</body>
</html>
