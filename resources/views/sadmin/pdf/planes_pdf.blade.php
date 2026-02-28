<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Listado de Planes</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .fecha {
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        /* ===== DESTACADO ===== */
        .destacado {
            background-color: #eef2ff;
            border: 2px solid #2563eb;
        }

        .badge-destacado {
            display: inline-block;
            padding: 4px 8px;
            background-color: #2563eb;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            border-radius: 12px;
        }

        /* ===== BENEFICIOS ===== */
        ul.beneficios {
            padding-left: 16px;
            margin: 0;
        }

        ul.beneficios li {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <h2>Listado de Planes del Sistema</h2>

    <div class="fecha">
        Fecha de impresión: {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 18%">Plan</th>
                <th style="width: 34%">Descripción / Beneficios</th>
                <th style="width: 14%">Precio</th>
                <th style="width: 14%">Duración</th>
                <th style="width: 20%">Destacado</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($planes as $plan)
                <tr class="{{ $plan->es_destacado ? 'destacado' : '' }}">
                    <td>
                        <strong>{{ $plan->nomb_plan }}</strong>
                    </td>

                    <td>
                        @if (is_array($plan->descripcion))
                            <ul class="beneficios">
                                @foreach ($plan->descripcion as $beneficio)
                                    <li>{{ $beneficio }}</li>
                                @endforeach
                            </ul>
                        @else
                            {{ $plan->descripcion }}
                        @endif
                    </td>

                    <td class="text-center">
                        ${{ number_format($plan->valor, 0) }}
                    </td>

                    <td class="text-center">
                        {{ $plan->duracion ? $plan->duracion . ' días' : 'Ilimitado' }}
                    </td>

                    <td class="text-center">
                        @if ($plan->es_destacado)
                            <span class="badge-destacado">⭐ PLAN DESTACADO</span>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
