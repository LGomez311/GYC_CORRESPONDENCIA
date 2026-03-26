<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Correspondencia</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ed1b2f;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #222;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .info-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #ed1b2f;
        }

        .info-box h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table td.left-align {
            text-align: left;
        }

        .badge-green {
            color: #15803d;
            font-weight: bold;
        }

        .badge-yellow {
            color: #a16207;
            font-weight: bold;
        }

        .badge-red {
            color: #b91c1c;
            font-weight: bold;
        }

        .badge-blue {
            color: #1d4ed8;
            font-weight: bold;
        }

        .metrics {
            width: 100%;
            margin-bottom: 20px;
        }

        .metrics td {
            border: none;
            padding: 10px;
            text-align: center;
            background: #f8fafc;
            border-radius: 5px;
        }

        .metrics h2 {
            margin: 0;
            font-size: 22px;
            color: #1e293b;
        }

        .metrics p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>REPORTE DE CORRESPONDENCIA</h1>
        <p>Generado por: <strong>{{ auth()->user()->emple_nombres }} {{ auth()->user()->emple_apellidos }}</strong> -
            Área: <strong style="color: #1d4ed8;">{{ auth()->user()->area->area_nom ?? 'N/A' }}</strong></p>
        <p>Fecha de Generación: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info-box">
        <h3>Parámetros del Reporte</h3>
        <p><strong>Mes Base:</strong> {{ date('m/Y', strtotime($mesSelect . '-01')) }}</p>
        <p><strong>Rango Aplicado:</strong> {{ strtoupper(str_replace('_', ' ', $rangoSelect)) }}</p>
        <p><strong>Fechas Consultadas:</strong> {{ $rangoFechas }}</p>
    </div>

    <h3>Resumen General (Unidades)</h3>
    <table class="metrics" cellspacing="10">
        <tr>
            <td>
                <h2>{{ $countRecibido }}</h2>
                <p>Recibidos</p>
            </td>
            <td>
                <h2>{{ $countTramite }}</h2>
                <p>En Trámite</p>
            </td>
            <td>
                <h2>{{ $countFinalizado }}</h2>
                <p>Finalizados</p>
            </td>
            <td>
                <h2>{{ $countRechazado }}</h2>
                <p>Rechazados</p>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <h3 style="margin-bottom: 20px; color: #1e293b;">Gráfica Consolidada del Periodo</h3>
        @if (!empty($chartImage))
            <img src="{{ $chartImage }}"
                style="width: 100%; max-width: 600px; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background: #fff;"
                alt="Gráfica de Correspondencia" />
            <div style="margin-top: 15px; font-size: 16px; color: #1d4ed8; font-weight: bold;">
                Trámites Totales: {{ $totalDocs }}
            </div>
        @else
            <p style="color: #999; padding: 30px; border: 1px dashed #ccc;">No se pudo graficar la información visual,
                pero los datos consolidados se encuentran en la tabla superior.</p>
        @endif
    </div>

    <div class="footer">
        Este documento es generado automáticamente por el sistema EASYCOR. Página 1.
    </div>

</body>

</html>
