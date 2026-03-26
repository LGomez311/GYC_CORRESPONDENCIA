<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Departamentos</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #2d6cdf;
        }

        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #2d6cdf;
            color: white;
        }

        th {
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }

        td {
            padding: 6px;
            border: 1px solid #e5e5e5;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f7ff;
        }

        .total {
            margin-top: 10px;
            font-size: 11px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 30px;
            font-size: 9px;
            color: #777;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>

</head>

<body>

    <!-- ENCABEZADO -->
    <div class="header">
        <h1>REPORTE DE DEPARTAMENTOS</h1>
    </div>

    <!-- INFORMACIÓN -->
    <div class="info">
        Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br>
    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código Postal</th>
                <th>Nombre del Departamento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departamentos as $index => $dpto)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dpto->dpto_codigo_postal }}</td>
                    <td>{{ $dpto->dpto_nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total">
        Total de registros: {{ $departamentos->count() }}
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Página <span class="page-number"></span>
    </div>

</body>
</html>
