<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pagos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Listado de Pagos</h2>

<table>
    <thead>
        <tr>
            <th>ID Pago</th>
            <th>Plan</th>
            <th>Monto</th>
            <th>Fecha de Pago</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($pagos as $pago)
            <tr>
                <td>{{ $pago->id_pago }}</td>
                <td>{{ $pago->plan->nomb_plan ?? '-' }}</td>
                <td>{{ number_format($pago->monto, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i') }}</td>
                <td>{{ $pago->estado->estado_nomb ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
