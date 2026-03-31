<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Productividad Personal</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #1e293b; margin: 0; padding: 40px; background-color: #ffffff; }
        .header-container { border-bottom: 2px solid #1e63e9; padding-bottom: 20px; margin-bottom: 30px; }
        .header-title { font-size: 24px; font-weight: 900; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: -0.5px; }
        .header-subtitle { font-size: 10px; color: #64748b; font-weight: bold; margin-top: 5px; text-transform: uppercase; letter-spacing: 2px; }
        
        .meta-info { margin-bottom: 30px; padding: 15px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; }
        .meta-item { display: inline-block; width: 48%; margin-bottom: 5px; }
        .meta-label { color: #64748b; font-weight: bold; }
        .meta-value { color: #0f172a; font-weight: 900; }
        
        .stats-grid { width: 100%; margin-bottom: 30px; border-spacing: 10px; }
        .stat-card { background-color: #ffffff; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; text-align: center; }
        .stat-label { color: #64748b; font-size: 8px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .stat-value { font-size: 18px; font-weight: 900; color: #0f172a; }
        
        .main-chart { margin-bottom: 40px; text-align: center; padding: 20px; border: 1px solid #e2e8f0; border-radius: 16px; background-color: #f8fafc; }
        .main-chart img { max-width: 100%; height: auto; }
        
        .footer { position: fixed; bottom: 20px; left: 40px; right: 40px; border-top: 1px solid #e2e8f0; padding-top: 10px; font-size: 8px; color: #94a3b8; }
        .footer-left { float: left; }
        .footer-right { float: right; }
        .page-number:after { content: counter(page); }
    </style>
</head>
<body>
    <div class="header-container">
        <h1 class="header-title">Reporte de Productividad</h1>
        <p class="header-subtitle">Panel de Gestión Individual · G&C Correspondencia</p>
    </div>

    <div class="meta-info">
        <div class="meta-item"><span class="meta-label">Empleado:</span> <span class="meta-value">{{ Auth::user()->emple_nombres }} {{ Auth::user()->emple_apellidos }}</span></div>
        <div class="meta-item"><span class="meta-label">Período:</span> <span class="meta-value">{{ $rangoFechas }}</span></div>
        <div class="meta-item"><span class="meta-label">Fecha de Reporte:</span> <span class="meta-value">{{ now()->format('d/m/Y H:i') }}</span></div>
        <div class="meta-item"><span class="meta-label">Total Radicados:</span> <span class="meta-value">{{ $totalDocs }}</span></div>
    </div>

    <table class="stats-grid">
        <tr>
            <td class="stat-card">
                <div class="stat-label">Recibidos</div>
                <div class="stat-value" style="color: #3b82f6;">{{ $countRecibido }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">En Trámite</div>
                <div class="stat-value" style="color: #d97706;">{{ $countTramite }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Finalizados</div>
                <div class="stat-value" style="color: #059669;">{{ $countFinalizado }}</div>
            </td>
        </tr>
        <tr>
            <td class="stat-card">
                <div class="stat-label">Archivados</div>
                <div class="stat-value" style="color: #64748b;">{{ $countArchivado }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Rechazados</div>
                <div class="stat-value" style="color: #dc2626;">{{ $countRechazado }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Vencidos</div>
                <div class="stat-value" style="color: #ef4444;">{{ $countVencidos }}</div>
            </td>
        </tr>
    </table>

    <div class="main-chart">
        <h3 style="color: #0f172a; margin-top: 0; font-size: 14px; font-weight: 900; text-transform: uppercase;">DISTRIBUCIÓN DE ESTADOS</h3>
        @if(isset($chartImage) && $chartImage)
            <img src="{{ $chartImage }}" />
        @else
            <p style="color: #94a3b8; font-style: italic; margin: 40px;">No hay representación gráfica disponible.</p>
        @endif
    </div>

    <div class="footer">
        <div class="footer-left">Generado por G&C Correspondencia · Sistema de Gestión Inteligente</div>
        <div class="footer-right">Página <span class="page-number"></span></div>
    </div>
</body>
</html>
