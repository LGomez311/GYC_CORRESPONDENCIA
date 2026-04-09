<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Productividad Personal</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9px;
            color: #1e293b;
            background: #fff;
            line-height: 1.4;
        }

        /* ====== HEADER ====== */
        .header-wrap {
            background: linear-gradient(135deg, #1d4ed8 0%, #0d9488 100%);
            padding: 25px 30px 20px;
            margin-bottom: 20px;
        }
        .header-top {
            width: 100%;
        }
        .header-title {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header-sub {
            color: rgba(255,255,255,0.8);
            font-size: 10px;
            margin-top: 4px;
        }
        
        .header-badges {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: 700;
        }

        /* ====== DATA BOX ====== */
        .content-container {
            padding: 0 30px;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            width: 100%;
        }
        
        .info-grid {
            width: 100%;
        }
        
        .info-item {
            width: 50%;
            padding: 3px 0;
        }
        
        .info-label {
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 7.5px;
        }
        
        .info-value {
            color: #0f172a;
            font-weight: 700;
            font-size: 9px;
        }

        /* ====== STATS CARDS ====== */
        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 12px;
            border-collapse: separate;
            margin-left: -12px;
            margin-right: -12px;
        }
        
        .stat-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 15px 10px;
            text-align: center;
            border-radius: 12px;
            width: 33.33%;
        }
        
        .stat-card.blue   { border-left: 4px solid #3b82f6; background: #eff6ff; }
        .stat-card.amber  { border-left: 4px solid #f59e0b; background: #fffbeb; }
        .stat-card.green  { border-left: 4px solid #10b981; background: #f0fdf4; }
        .stat-card.slate  { border-left: 4px solid #64748b; background: #f8fafc; }
        .stat-card.red    { border-left: 4px solid #ef4444; background: #fef2f2; }
        .stat-card.orange { border-left: 4px solid #f97316; background: #fff7ed; }

        .stat-num {
            display: block;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .stat-card.blue   .stat-num { color: #1d4ed8; }
        .stat-card.amber  .stat-num { color: #b45309; }
        .stat-card.green  .stat-num { color: #047857; }
        .stat-card.slate  .stat-num { color: #334155; }
        .stat-card.red    .stat-num { color: #b91c1c; }
        .stat-card.orange .stat-num { color: #c2410c; }

        .stat-label {
            display: block;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-top: 5px;
        }

        /* ====== CHART SECTION ====== */
        .chart-box {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .chart-title {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .chart-box img {
            max-width: 90%;
            height: auto;
            max-height: 300px;
        }

        /* ====== FOOTER ====== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 30px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 7.5px;
            color: #94a3b8;
        }
        
        .footer-table {
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="header-wrap">
        <div class="header-top">
            <h1 class="header-title">Reporte de Productividad Individual</h1>
            <p class="header-sub">G&C Correspondencia — Gestión Inteligente de Documentos</p>
        </div>
        
        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="width: 30%;"><div class="badge">EMPLEADO: {{ Auth::user()->emple_nombres }}</div></td>
                <td style="width: 40%; text-align: center;"><div class="badge">PERÍODO: {{ $rangoFechas }}</div></td>
                <td style="width: 30%; text-align: right;"><div class="badge">FECHA: {{ now()->format('d/m/Y') }}</div></td>
            </tr>
        </table>
    </div>

    <div class="content-container">
        <div class="info-box">
            <table class="info-grid">
                <tr>
                    <td class="info-item">
                        <span class="info-label">Funcionario Destinatario:</span><br>
                        <span class="info-value">{{ Auth::user()->emple_nombres }} {{ Auth::user()->emple_apellidos }}</span>
                    </td>
                    <td class="info-item">
                        <span class="info-label">Total de Documentos Gestionados:</span><br>
                        <span class="info-value">{{ $totalDocs }} Radicaciones</span>
                    </td>
                </tr>
                <tr>
                    <td class="info-item">
                        <span class="info-label">Empresa / NIT:</span><br>
                        <span class="info-value">{{ auth()->user()->nit_empresa }}</span>
                    </td>
                    <td class="info-item">
                        <span class="info-label">Generado Por:</span><br>
                        <span class="info-value">Sistema Automático de Métricas</span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="stats-grid">
            <tr>
                <td class="stat-card blue">
                    <span class="stat-num">{{ $countRecibido }}</span>
                    <span class="stat-label">Recibidos</span>
                </td>
                <td class="stat-card amber">
                    <span class="stat-num">{{ $countTramite }}</span>
                    <span class="stat-label">En Trámite</span>
                </td>
                <td class="stat-card green">
                    <span class="stat-num">{{ $countFinalizado }}</span>
                    <span class="stat-label">Finalizados</span>
                </td>
            </tr>
            <tr>
                <td class="stat-card slate">
                    <span class="stat-num">{{ $countArchivado }}</span>
                    <span class="stat-label">Archivados</span>
                </td>
                <td class="stat-card red">
                    <span class="stat-num">{{ $countRechazado }}</span>
                    <span class="stat-label">Rechazados</span>
                </td>
                <td class="stat-card orange">
                    <span class="stat-num">{{ $countVencidos }}</span>
                    <span class="stat-label">Vencidos</span>
                </td>
            </tr>
        </table>

        <div class="chart-box">
            <h3 class="chart-title">Visualización de Rendimiento por Estado</h3>
            @if(isset($chartImage) && $chartImage)
                <img src="{{ $chartImage }}" />
            @else
                <div style="padding: 50px; color: #94a3b8; font-style: italic;">
                    No hay representación gráfica disponible.
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="width: 50%;">Sistema de Gestión de Correspondencia G&C — Módulo de Productividad</td>
                <td style="width: 50%; text-align: right;">Generado el {{ now()->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
