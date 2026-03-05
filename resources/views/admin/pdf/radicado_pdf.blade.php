<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Radicados</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #333; }
        h2 { text-align: center; color: #333; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; padding-top: 10px; border-top: 1px solid #ddd; }
    </style>
</head>
<body>

    <h2>Reporte Completo de Radicados Registrados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Radicado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($radicados as $r)
            <tr>
                <td>{{ $r->id_radicado }}</td>
                <td>{{ $r->num_radicado }}</td>
                <td>{{ $r->estado->estado_nomb ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ date('d/m/Y H:i:s') }} - Sistema de Correspondencia
    </div>

</body>
</html>
