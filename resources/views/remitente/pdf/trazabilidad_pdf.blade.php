<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trazabilidad Radicado {{ $radicado }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1a56db; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; color: #1a56db; text-transform: uppercase; }
        .subtitle { font-size: 14px; margin: 5px 0; font-weight: bold; }
        .meta-info { font-size: 11px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px 8px; text-align: left; vertical-align: top; }
        th { background-color: #f8fafc; color: #1e293b; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #fbfbfc; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 5px; border-radius: 3px; font-size: 10px; font-weight: bold; border: 1px solid #ccc; background-color: #eee; }
        .timeline-cell { min-width: 100px; }
        .observaciones { font-style: italic; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Reporte de Trazabilidad Histórica</h1>
        <p class="subtitle">Radicado: <span style="color: #d97706;">{{ $radicado }}</span></p>
        <p class="meta-info">Asunto: {{ $asunto }}</p>
        <p class="meta-info">Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="timeline-cell">Fecha / Hora</th>
                <th>Estado / Movimiento</th>
                <th>Responsable</th>
                <th>Área / Entidad</th>
                <th>Detalles / Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $h)
            <tr>
                <td class="timeline-cell text-center">
                    <strong>{{ \Carbon\Carbon::parse($h['fecha'])->format('d/m/Y') }}</strong><br>
                    <small style="color:#777;">{{ \Carbon\Carbon::parse($h['fecha'])->format('h:i A') }}</small>
                </td>
                <td>
                    <span class="badge">{{ $h['estado_nomb'] ?? 'Desconocido' }}</span>
                    @if(isset($h['type']) && $h['type'] === 'registry')
                        <br><small style="color:#777;">(Registro de Radicación)</small>
                    @endif
                </td>
                <td>
                    {{ $h['nombres'] ?? '' }} {{ $h['apellidos'] ?? '' }}
                </td>
                <td>
                    {{ $h['area_e'] ?? 'N/A' }}
                </td>
                <td class="observaciones">
                    {{ $h['observaciones'] ?? 'Sin observaciones' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 10px; font-size: 10px; color: #888; text-align: center;">
        <p>Documento generado automáticamente por el Sistema de Gestión de Correspondencia.</p>
    </div>
</body>
</html>
