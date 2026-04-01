<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Gestión — Ventanilla</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            color: #1e293b;
            background: #ffffff;
            padding: 30px 35px;
        }

        /* ===== HEADER ===== */
        .header {
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 14px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .header-left .title {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: -0.3px;
        }
        .header-left .subtitle {
            font-size: 8px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .date {
            font-size: 8px;
            color: #64748b;
            font-weight: 700;
        }
        .header-right .filter-badge {
            display: inline-block;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 7.5px;
            font-weight: 700;
            margin-top: 4px;
        }

        /* ===== SUMMARY CARDS ===== */
        .summary-row {
            width: 100%;
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }
        .summary-card {
            flex: 1;
            border-radius: 8px;
            padding: 10px 12px;
            text-align: center;
            border: 1px solid;
        }
        .card-blue   { background: #eff6ff; border-color: #bfdbfe; }
        .card-amber  { background: #fffbeb; border-color: #fde68a; }
        .card-green  { background: #f0fdf4; border-color: #bbf7d0; }
        .card-red    { background: #fff1f2; border-color: #fecdd3; }
        .card-indigo { background: #eef2ff; border-color: #c7d2fe; }

        .card-num {
            display: block;
            font-size: 20px;
            font-weight: 900;
            line-height: 1;
        }
        .card-blue   .card-num { color: #1d4ed8; }
        .card-amber  .card-num { color: #d97706; }
        .card-green  .card-num { color: #16a34a; }
        .card-red    .card-num { color: #dc2626; }
        .card-indigo .card-num { color: #4f46e5; }
        .card-label {
            display: block;
            font-size: 6.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            margin-top: 4px;
        }

        /* ===== CHARTS ===== */
        .charts-section {
            width: 100%;
            margin-bottom: 18px;
            display: flex;
            gap: 10px;
        }
        .chart-box {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background: #fafafa;
        }
        .chart-box img {
            width: 100%;
            height: auto;
            max-height: 200px;
        }
        .chart-title {
            font-size: 8px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .no-chart {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #94a3b8;
            font-style: italic;
        }

        /* ===== TIPO TABLE ===== */
        .section-title {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #334155;
            border-left: 3px solid #1d4ed8;
            padding-left: 8px;
            margin-bottom: 10px;
            margin-top: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        thead tr { background: #0f172a; color: #fff; }
        th {
            padding: 8px 7px;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
        }
        td {
            padding: 7px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 8.5px;
            text-align: center;
            color: #334155;
        }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .td-left { text-align: left; padding-left: 14px; font-weight: 700; color: #0f172a; }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 20px;
            font-size: 7.5px;
            font-weight: 900;
        }
        .badge-green  { background: #dcfce7; color: #166534; }
        .badge-amber  { background: #fef3c7; color: #92400e; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-blue   { background: #dbeafe; color: #1e40af; }

        .efficiency-bar-wrap {
            background: #e2e8f0;
            border-radius: 6px;
            height: 6px;
            width: 80px;
            display: inline-block;
            vertical-align: middle;
            overflow: hidden;
            margin-left: 6px;
        }
        .efficiency-bar {
            height: 100%;
            border-radius: 6px;
        }
        .bar-green  { background: #22c55e; }
        .bar-amber  { background: #f59e0b; }
        .bar-red    { background: #ef4444; }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 15px;
            left: 35px;
            right: 35px;
            border-top: 1px solid #e2e8f0;
            padding-top: 7px;
            font-size: 7px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="title">Reporte de Gestión</div>
            <div class="subtitle">Sistema de Gestión Documental · Módulo Ventanilla</div>
        </div>
        <div class="header-right">
            <div class="date">Generado: {{ now()->format('d/m/Y H:i') }}</div>
            <div class="filter-badge">{{ $filtroLabel ?? 'Histórico Completo' }}</div>
        </div>
    </div>

    {{-- TARJETAS RESUMEN --}}
    <div class="summary-row">
        <div class="summary-card card-blue">
            <span class="card-num">{{ number_format($totalAsignados) }}</span>
            <span class="card-label">Total Asignados</span>
        </div>
        <div class="summary-card card-amber">
            <span class="card-num">{{ number_format($totalTramite) }}</span>
            <span class="card-label">En Trámite</span>
        </div>
        <div class="summary-card card-green">
            <span class="card-num">{{ number_format($totalFinalizado) }}</span>
            <span class="card-label">Finalizados</span>
        </div>
        <div class="summary-card card-red">
            <span class="card-num">{{ number_format($totalVencidos) }}</span>
            <span class="card-label">Vencidos</span>
        </div>
        <div class="summary-card card-indigo">
            <span class="card-num">{{ $eficienciaGlobal }}%</span>
            <span class="card-label">Eficiencia Global</span>
        </div>
    </div>

    {{-- GRÁFICAS (si existen) --}}
    @if((isset($barChart) && $barChart) || (isset($doughnutChart) && $doughnutChart))
    <div class="charts-section">
        <div class="chart-box">
            <div class="chart-title">Carga de Trabajo por Área</div>
            @if(isset($barChart) && $barChart)
                <img src="{{ $barChart }}" alt="Gráfico de barras">
            @else
                <div class="no-chart">Sin datos de gráfico</div>
            @endif
        </div>
        <div class="chart-box">
            <div class="chart-title">Índice de Eficiencia</div>
            @if(isset($doughnutChart) && $doughnutChart)
                <img src="{{ $doughnutChart }}" alt="Gráfico circular">
            @else
                <div class="no-chart">Sin datos de gráfico</div>
            @endif
        </div>
    </div>
    @endif

    {{-- RESUMEN POR TIPO --}}
    <div class="section-title">Distribución por Naturaleza</div>
    @php $totalTipos = array_sum($resumenTipos); @endphp
    <table style="margin-bottom: 4px;">
        <thead>
            <tr>
                <th style="text-align:left; padding-left:14px;">Naturaleza</th>
                <th>Cantidad</th>
                <th>Participación</th>
                <th>Indicador</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="td-left">Correspondencia Interna</td>
                <td><strong>{{ $resumenTipos['Interna'] ?? 0 }}</strong></td>
                <td>{{ $totalTipos > 0 ? round((($resumenTipos['Interna'] ?? 0) / $totalTipos) * 100) : 0 }}%</td>
                <td><span class="badge badge-blue">Interna</span></td>
            </tr>
            <tr>
                <td class="td-left">Correspondencia Externa (Entrante)</td>
                <td><strong>{{ $resumenTipos['Externa'] ?? 0 }}</strong></td>
                <td>{{ $totalTipos > 0 ? round((($resumenTipos['Externa'] ?? 0) / $totalTipos) * 100) : 0 }}%</td>
                <td><span class="badge badge-amber">Externa</span></td>
            </tr>
            <tr>
                <td class="td-left">Correspondencia Saliente (Respuesta)</td>
                <td><strong>{{ $resumenTipos['Saliente'] ?? 0 }}</strong></td>
                <td>{{ $totalTipos > 0 ? round((($resumenTipos['Saliente'] ?? 0) / $totalTipos) * 100) : 0 }}%</td>
                <td><span class="badge badge-green">Saliente</span></td>
            </tr>
        </tbody>
    </table>

    {{-- DESGLOSE POR ÁREAS --}}
    <div class="section-title">Eficiencia por Dependencias</div>

    @if(count($reporteAreas) > 0)
    <table>
        <thead>
            <tr>
                <th style="text-align:left; padding-left:14px; width:28%">Dependencia</th>
                <th style="width:12%">Asignados</th>
                <th style="width:12%">En Trámite</th>
                <th style="width:12%">Finalizados</th>
                <th style="width:12%">Vencidos</th>
                <th style="width:24%">Eficiencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporteAreas as $area)
                @php
                    $efic = $area['eficiencia'];
                    $barClass = $efic >= 70 ? 'bar-green' : ($efic >= 45 ? 'bar-amber' : 'bar-red');
                    $badgeClass = $efic >= 70 ? 'badge-green' : ($efic >= 45 ? 'badge-amber' : 'badge-red');
                @endphp
                <tr>
                    <td class="td-left">{{ $area['area_nom'] }}</td>
                    <td style="font-weight:700">{{ $area['asignados'] }}</td>
                    <td style="color:#d97706; font-weight:700">{{ $area['tramite'] }}</td>
                    <td style="color:#16a34a; font-weight:700">{{ $area['finalizado'] }}</td>
                    <td style="{{ $area['vencidos'] > 0 ? 'color:#dc2626; font-weight:700;' : 'color:#cbd5e1;' }}">
                        {{ $area['vencidos'] }}
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass }}">{{ $efic }}%</span>
                        <span class="efficiency-bar-wrap">
                            <span class="efficiency-bar {{ $barClass }}" style="width:{{ $efic }}%;"></span>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align:center; padding:20px; color:#94a3b8; font-style:italic; border:1px dashed #e2e8f0; border-radius:8px;">
            No se encontraron registros en el período seleccionado.
        </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <span>Sistema de Gestión Documental · G&C Correspondencia</span>
        <span>Pág. <span></span></span>
    </div>

</body>
</html>
