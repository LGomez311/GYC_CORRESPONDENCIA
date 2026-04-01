<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Correspondencia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            color: #1e293b;
            background: #fff;
        }

        /* ====== HEADER ====== */
        .header-wrap {
            background: linear-gradient(135deg, #1d4ed8 0%, #0d9488 100%);
            padding: 18px 24px 14px;
            margin-bottom: 12px;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .header-title {
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header-sub {
            color: rgba(255,255,255,0.8);
            font-size: 9px;
            margin-top: 3px;
        }
        .header-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 700;
            text-align: center;
        }
        .header-badge-date {
            font-size: 7px;
            margin-top: 2px;
            color: rgba(255,255,255,0.7);
        }

        /* ====== FILTROS ====== */
        .filters-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            padding: 8px 12px;
            margin: 0 10px 10px;
        }
        .filters-title {
            font-size: 8px;
            font-weight: 700;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
        }
        .filters-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .filter-tag {
            background: #e0f2fe;
            border: 1px solid #7dd3fc;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 7.5px;
            color: #0369a1;
        }
        .filter-tag strong { font-weight: 700; }

        /* ====== STATS SUMMARY ====== */
        .stats-row {
            display: flex;
            gap: 8px;
            margin: 0 10px 12px;
        }
        .stat-card {
            flex: 1;
            border-radius: 6px;
            padding: 8px 10px;
            text-align: center;
            border: 1px solid;
        }
        .stat-card.blue   { background: #eff6ff; border-color: #bfdbfe; }
        .stat-card.amber  { background: #fffbeb; border-color: #fde68a; }
        .stat-card.green  { background: #f0fdf4; border-color: #bbf7d0; }
        .stat-card.red    { background: #fff1f2; border-color: #fecdd3; }
        .stat-num {
            display: block;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
        }
        .stat-card.blue   .stat-num { color: #1d4ed8; }
        .stat-card.amber  .stat-num { color: #d97706; }
        .stat-card.green  .stat-num { color: #16a34a; }
        .stat-card.red    .stat-num { color: #dc2626; }
        .stat-label {
            display: block;
            font-size: 7px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-top: 3px;
        }

        /* ====== TABLE ====== */
        .table-wrap {
            margin: 0 10px;
        }
        .table-section-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        thead tr {
            background: #1e40af;
            color: #fff;
        }
        th {
            padding: 6px 5px;
            text-align: center;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        th:first-child { border-radius: 4px 0 0 4px; }
        th:last-child  { border-radius: 0 4px 4px 0; }
        td {
            padding: 5px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 8px;
            vertical-align: top;
            word-break: break-word;
        }
        tbody tr:nth-child(even) { background: #f8faff; }
        tbody tr:last-child td { border-bottom: 2px solid #e2e8f0; }

        .radicado-badge {
            display: inline-block;
            background: #e0e7ff;
            color: #3730a3;
            border-radius: 10px;
            padding: 1px 5px;
            font-size: 7px;
            font-weight: 700;
        }
        .status-pill {
            display: inline-block;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 7px;
            font-weight: 700;
        }
        .status-pending  { background:#fef3c7; color:#92400e; }
        .status-active   { background:#dbeafe; color:#1e40af; }
        .status-resolved { background:#d1fae5; color:#065f46; }
        .status-rejected { background:#fee2e2; color:#991b1b; }
        .status-default  { background:#f1f5f9; color:#475569; }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
            font-style: italic;
        }

        /* ====== FOOTER ====== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 6px 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            font-size: 7px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header-wrap">
        <div class="header-top">
            <div>
                <div class="header-title">REPORTE DE CORRESPONDENCIA</div>
                <div class="header-sub">Correspondencia Recibida — Módulo Ventanilla / Remitente</div>
            </div>
            <div>
                <div class="header-badge">
                    {{ $totalRegistros }} REGISTROS
                    <div class="header-badge-date">{{ now()->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTROS ACTIVOS --}}
    @if(!empty($filtrosActivos))
    <div class="filters-box">
        <div class="filters-title">🔍 Filtros Aplicados</div>
        <div class="filters-grid">
            @foreach($filtrosActivos as $nombre => $valor)
                <span class="filter-tag"><strong>{{ $nombre }}:</strong> {{ $valor }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- RESUMEN ESTADÍSTICO --}}
    <div class="stats-row">
        <div class="stat-card blue">
            <span class="stat-num">{{ $totalRegistros }}</span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-card amber">
            <span class="stat-num">{{ $totalEnProceso }}</span>
            <span class="stat-label">En Proceso</span>
        </div>
        <div class="stat-card green">
            <span class="stat-num">{{ $totalFinalizados }}</span>
            <span class="stat-label">Finalizados</span>
        </div>
        <div class="stat-card red">
            <span class="stat-num">{{ $totalRechazados }}</span>
            <span class="stat-label">Rechazados</span>
        </div>
    </div>

    {{-- TABLA DE CORRESPONDENCIA --}}
    <div class="table-wrap">
        <div class="table-section-title">Listado de Correspondencia Recibida</div>

        @if($correspondencias->isEmpty())
            <div class="empty-state">No se encontraron registros con los filtros aplicados.</div>
        @else
        <table>
            <thead>
                <tr>
                    <th style="width:4%">#</th>
                    <th style="width:12%">Radicado</th>
                    <th style="width:18%">Remitente / Institución</th>
                    <th style="width:22%">Asunto</th>
                    <th style="width:10%">Tipo Doc.</th>
                    <th style="width:14%">Destinatario(s)</th>
                    <th style="width:10%">Fecha</th>
                    <th style="width:10%">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($correspondencias as $i => $c)
                    @php
                        $idEst = $c->id_estado_rec;
                        $pillClass = 'status-default';
                        if (in_array($idEst, [9,10,14])) $pillClass = 'status-resolved';
                        elseif ($idEst == 11) $pillClass = 'status-rejected';
                        elseif (in_array($idEst, [7,12])) $pillClass = 'status-active';
                        elseif (in_array($idEst, [8,13])) $pillClass = 'status-pending';

                        $destinatariosStr = $c->destinatarios->isEmpty()
                            ? 'Sin asignar'
                            : $c->destinatarios->map(fn($d) => $d->emple_nombres . ' ' . $d->emple_apellidos)->implode(' / ');
                    @endphp
                    <tr>
                        <td style="text-align:center; color:#94a3b8">{{ $i + 1 }}</td>
                        <td style="text-align:center">
                            <span class="radicado-badge">
                                {{ $c->radicado ? $c->radicado->num_radicado : 'S/R' }}
                            </span>
                            @if($c->num_radicado_ext)
                                <br><span style="color:#64748b; font-size:6.5px">Ext: {{ $c->num_radicado_ext }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $c->nom_institucion ?: ($c->nombre_persona ?? 'Particular') }}</strong>
                            @if($c->ciudad)
                                <br><span style="color:#94a3b8; font-size:7px">{{ $c->ciudad->ciudad_nom ?? '' }}</span>
                            @endif
                        </td>
                        <td>{{ $c->asunto }}</td>
                        <td style="text-align:center">
                            {{ $c->tipo ? $c->tipo->tipo_nombre : 'N/A' }}
                        </td>
                        <td style="font-size:7.5px">{{ $destinatariosStr }}</td>
                        <td style="text-align:center">
                            {{ $c->fecha_hora_recib ? \Carbon\Carbon::parse($c->fecha_hora_recib)->format('d/m/Y') : '—' }}
                        </td>
                        <td style="text-align:center">
                            <span class="status-pill {{ $pillClass }}">
                                {{ $c->estado ? $c->estado->estado_nomb : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <span>Sistema de Gestión de Correspondencia — Módulo Remitente</span>
        <span>Generado: {{ now()->format('d/m/Y H:i:s') }}</span>
        <span>Pág. <span style="font-weight:700"></span></span>
    </div>

</body>
</html>
