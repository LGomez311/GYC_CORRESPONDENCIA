<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Listado de Licencias</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>NIT</th>
                <th>Plan</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Tipo de licencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Licencia::with(['pago.admin.empresa','pago.plan','estado'])->get() as $licencia)
            <tr>
                <td>{{ $licencia->id_licencia }}</td>
                <td>{{ $licencia->pago->admin->empresa->nomb_empresa ?? 'Empresa no encontrada' }}</td>
                <td>{{ $licencia->pago->admin->empresa->nit_empresa ?? '-' }}</td>
                <td>{{ $licencia->pago->plan->nomb_plan ?? '-' }}</td>
                <td>{{ $licencia->estado->estado_nomb ?? '-' }}</td>
                <td>{{ $licencia->fecha_inicio }}</td>
                <td>{{ $licencia->fecha_fin }}</td>
                <td>{{ $licencia->tipo_licencia }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
