<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Estados</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size:11px; margin:30px }
        .header { text-align:center; margin-bottom:15px }
        .header h1 { margin:0; font-size:18px; color:#2d6cdf }
        table { width:100%; border-collapse:collapse }
        thead { background-color:#2d6cdf; color:#fff }
        th, td { padding:8px; text-align:center; border:1px solid #e5e5e5 }
        tbody tr:nth-child(even) { background:#f4f7ff }
    </style>
</head>
<body>
    <div class="header"><h1>REPORTE DE ESTADOS</h1></div>
    <div class="info">Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estados as $i => $e)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $e->id_estado }}</td>
                    <td>{{ $e->estado_nomb }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">Total: {{ $estados->count() }}</div>
</body>
</html>
