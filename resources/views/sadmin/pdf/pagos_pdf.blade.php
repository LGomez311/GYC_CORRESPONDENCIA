<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Listado de Pagos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .fecha {
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .destacado {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>Listado de Pagos de Licencias</h2>
    <table>
        <thead>
            <tr>
                <th>ID Pago</th>
                <th>Nit Empresa</th>
                <th>Plan Seleccionado</th>
                <th>Valor</th>
                <th>Fecha de Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
            <tr>
                <td class="text-center">{{ $pago->id_pago }}</td>
                <td>
                    @if($pago->admin)
                        {{ $pago->admin->nit_empresa }}
                    @endif
                </td>
                <td>{{ $pago->plan->nomb_plan ?? 'N/A' }}</td>
                <td class="text-center">${{ number_format($pago->valor, 0) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</td>
                <td class="text-center">{{ $pago->estado->estado_nomb ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
