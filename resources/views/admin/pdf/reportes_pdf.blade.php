<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Gestión Estratégica</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 40px; background-color: #ffffff; }
        .header-container { border-bottom: 2px solid #1e63e9; padding-bottom: 20px; margin-bottom: 30px; }
        .header-title { font-size: 24px; font-weight: 900; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: -0.5px; }
        .header-subtitle { font-size: 10px; color: #64748b; font-weight: bold; margin-top: 5px; text-transform: uppercase; letter-spacing: 2px; }
        
        .meta-info { margin-bottom: 30px; padding: 15px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; }
        .meta-item { display: inline-block; width: 48%; margin-bottom: 5px; }
        .meta-label { color: #64748b; font-weight: bold; }
        .meta-value { color: #0f172a; font-weight: 900; }
        
        .charts-container { margin-bottom: 40px; page-break-inside: avoid; }
        .chart-row { width: 100%; margin-bottom: 20px; }
        .chart-box { display: inline-block; width: 48%; vertical-align: top; text-align: center; }
        .chart-box img { width: 100%; height: auto; border: 1px solid #e2e8f0; border-radius: 16px; padding: 10px; background: white; }
        .chart-title { font-weight: 900; margin-bottom: 10px; font-size: 11px; color: #334155; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; }
        thead { background-color: #0f172a; color: #ffffff; }
        th { padding: 12px 8px; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; font-weight: 900; }
        td { padding: 10px 8px; border-bottom: 1px solid #f1f5f9; text-align: center; color: #334155; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        .area-name { font-weight: bold; text-align: left; padding-left: 20px; color: #0f172a; }
        .efficiency-badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-weight: 900; color: #ffffff; font-size: 9px; }
        
        .footer { position: fixed; bottom: 20px; left: 40px; right: 40px; border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 8px; color: #94a3b8; }
        .footer-left { float: left; }
        .footer-right { float: right; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header-container">
        <h1 class="header-title">Reporte de Gestión</h1>
        <p class="header-subtitle">Panel de Control Administrativo · G&C Correspondencia</p>
    </div>

    <div class="meta-info">
        <div class="meta-item">
            <span class="meta-label">Fecha de Generación:</span>
            <span class="meta-value">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Filtrado por:</span>
            <span class="meta-value">
                @if(request('periodo') && request('periodo') != 'todo')
                    @if(request('periodo') == 'dia' && request('fecha')) 
                        Día ({{ \Carbon\Carbon::parse(request('fecha'))->format('d/m/Y') }})
                    @elseif(request('periodo') == 'mes' && request('mes')) 
                        Mes ({{ request('mes') }})
                    @elseif(request('periodo') == 'trimestre' && request('trimestre')) 
                        Trimestre {{ request('trimestre') }} ({{ request('ano') }})
                    @elseif(request('periodo') == 'ano' && request('ano')) 
                        Año ({{ request('ano') }})
                    @endif
                @else
                    Histórico Completo
                @endif
            </span>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="charts-container">
        <div class="chart-row">
            @if(isset($barChart) && $barChart)
                <div class="chart-box" style="margin-right: 4%;">
                    <div class="chart-title">Carga de Trabajo por Área</div>
                    <img src="{{ $barChart }}" />
                </div>
            @endif
            @if(isset($doughnutChart) && $doughnutChart)
                <div class="chart-box">
                    <div class="chart-title">Eficiencia por Área</div>
                    <img src="{{ $doughnutChart }}" />
                </div>
            @endif
        </div>
    </div>

    <!-- Tabla Detalle -->
    <h3 style="color: #0f172a; margin-bottom: 15px; font-size: 14px; font-weight: 900;">DESGLOSE POR DEPENDENCIAS</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align: left; padding-left: 20px;">Dependencia</th>
                <th>Asignados</th>
                <th>En Trámite</th>
                <th>Finalizados</th>
                <th>Vencidos</th>
                <th>Eficiencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporteAreas as $area)
                <tr>
                    <td class="area-name">{{ $area['area_nom'] }}</td>
                    <td style="font-weight: bold;">{{ $area['asignados'] }}</td>
                    <td style="color: #d97706;">{{ $area['tramite'] }}</td>
                    <td style="color: #059669; font-weight: bold;">{{ $area['finalizado'] }}</td>
                    <td style="{{ $area['vencidos'] > 0 ? 'color: #dc2626; font-weight: bold;' : 'color: #cbd5e1;' }}">
                        {{ $area['vencidos'] }}
                    </td>
                    <td>
                        <span style="font-weight: 900; color: #1e63e9;">{{ $area['eficiencia'] }}%</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-left">Generado por G&C Correspondencia · Sistema de Gestión Inteligente</div>
        <div class="footer-right">Página <span class="page-number"></span></div>
    </div>
</body>
</html>
