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
            margin-bottom: 5px;
        }

        .fecha {
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .destacado {
            font-weight: bold;
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
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Duración</th>
                <th>Destacado</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($planes as $plan)
                <tr>
                    <td>{{ $plan->nomb_plan }}</td>

                    <td>
                        @if (is_array($plan->descripcion))
                            {{ implode(', ', $plan->descripcion) }}
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

                    <td class="text-center destacado">
                        {{ $plan->es_destacado ? 'Sí ⭐' : 'No' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
