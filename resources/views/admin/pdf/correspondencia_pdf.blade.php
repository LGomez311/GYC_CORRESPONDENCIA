<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Correspondencia</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #2d6cdf;
        }

        .info {
            margin-bottom: 10px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead {
            background-color: #2d6cdf;
            color: white;
        }

        th {
            padding: 5px;
            text-align: center;
            font-size: 9px;
            word-wrap: break-word;
        }

        td {
            padding: 4px;
            border: 1px solid #e5e5e5;
            text-align: left;
            word-wrap: break-word;
            font-size: 8px;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f7ff;
        }

        .total {
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 30px;
            font-size: 8px;
            color: #777;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE CORRESPONDENCIA</h1>
    </div>

    <div class="info">
        Fecha de reporte: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}<br>
        @if(!empty($filtrosActivos))
            <strong>Filtros aplicados:</strong>
            @foreach($filtrosActivos as $nombre => $valor)
                | {{ $nombre }}: <strong>{{ $valor }}</strong>
            @endforeach
        @else
            Mostrando: Toda la correspondencia (sin filtros).
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 8%">Ori</th>
                <th style="width: 10%">EXT</th>
                <th style="width: 10%">INT</th>
                <th style="width: 15%">Institución</th>
                <th style="width: 18%">Asunto</th>
                <th style="width: 10%">Ingreso</th>
                <th style="width: 12%">Destinatario</th>
                <th style="width: 10%">Docs</th>
                <th style="width: 10%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($correspondencias as $index => $cor)
                <tr>
                    <td style="text-align:center;">{{ $index + 1 }}</td>
                    <td style="text-align:center;">{{ substr($cor->origen, 0, 3) }}</td>
                    <td style="text-align:center;">{{ $cor->num_radicado_ext }}</td>
                    <td style="text-align:center;">{{ $cor->num_radicado_int }}</td>
                    <td>{{ $cor->nom_institucion }}<br><small>{{ $cor->ciudad }}</small></td>
                    <td>{{ $cor->asunto }}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($cor->fecha)->format('d/m/Y H:i') }}</td>
                    <td>{{ $cor->destinatario_nombre }}<br><small>Doc: {{ $cor->doc_destinatario }}</small></td>
                    <td>F: {{ $cor->folio }}<br>A: {{ $cor->digital_anexos }} dig, {{ $cor->anexo ?? '0 fís' }}</td>
                    <td style="text-align:center;">{{ $cor->estado_nomb }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total de registros: {{ count($correspondencias) }}
    </div>

    <div class="footer">
        Página <span class="page-number"></span>
    </div>
</body>
</html>
