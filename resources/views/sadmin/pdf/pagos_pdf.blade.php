<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Listado de Pagos</h2>
    <table>
        <thead>
            <tr>
                <th>ID Pago</th>
                <th>Plan</th>
                <th>Pagado por</th>
                <th>Fecha Pago</th>
                <th>Inicio Licencia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
            <tr>
                <td>{{ $pago->id_pago }}</td>
                <td>{{ $pago->plan->nomb_plan ?? '' }}</td>
                <td>
                    @if($pago->admin)
                        {{ $pago->admin->emple_nombres }} {{ $pago->admin->emple_apellidos }}
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') }}</td>
                <td>{{ \Carbon\Carbon::parse($pago->fecha_inicio)->format('Y-m-d') }}</td>
                <td>{{ $pago->estado->estado_nomb ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
