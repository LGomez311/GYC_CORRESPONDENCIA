<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Avanzado de Correspondencia</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #333; margin: 25px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #2d6cdf; }
        .info { margin-bottom: 20px; font-size: 10px; }
        
        .charts-container { 
            text-align: center; 
            margin-bottom: 30px; 
            page-break-inside: avoid;
        }
        .chart-box { 
            display: inline-block; 
            width: 45%; 
            margin: 2%; 
            vertical-align: top; 
            text-align: center; 
        }
        .chart-box img { 
            width: 100%; 
            height: auto;
            border: 1px solid #e5e5e5; 
            border-radius: 8px; 
        }
        .chart-title { font-weight: bold; margin-bottom: 8px; font-size: 12px; color: #444; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; page-break-inside: avoid; }
        thead { background-color: #2d6cdf; color: white; }
        th, td { padding: 8px; border: 1px solid #e5e5e5; text-align: center; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f9fbff; }
        
        .footer { position: fixed; bottom: 10px; right: 30px; font-size: 9px; color: #777; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE AVANZADO DE CORRESPONDENCIA</h1>
    </div>

    <div class="info">
        <strong>Fecha de reporte:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }} <br>
        @if(request('periodo') && request('periodo') != 'todo')
            <strong>Período filtrado:</strong> 
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
            <strong>Período filtrado:</strong> Todo el historial
        @endif
    </div>

    <!-- Gráficas -->
    <div class="charts-container">
        @if(isset($barChart) && $barChart)
            <div class="chart-box">
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

    <!-- Tabla Sumario -->
    <h3 style="color: #2d6cdf; margin-bottom: 8px; font-size: 14px;">Sumario de Rendimiento por Dependencia</h3>
    <table>
        <thead>
            <tr>
                <th>Área</th>
                <th>Asignados</th>
                <th>En Trámite</th>
                <th>Finalizados</th>
                <th style="color: red;">Vencidos</th>
                <th>Eficiencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporteAreas as $area)
                <tr>
                    <td>{{ $area['area_nom'] }}</td>
                    <td>{{ $area['asignados'] }}</td>
                    <td>{{ $area['tramite'] }}</td>
                    <td>{{ $area['finalizado'] }}</td>
                    <td style="{{ $area['vencidos'] > 0 ? 'color: red; font-weight: bold;' : '' }}">
                        {{ $area['vencidos'] }}
                    </td>
                    <td>{{ $area['eficiencia'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Página <span class="page-number"></span>
    </div>
</body>
</html>
