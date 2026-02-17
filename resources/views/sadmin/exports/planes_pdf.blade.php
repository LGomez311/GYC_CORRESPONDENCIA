<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Planes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background-color: #f3f4f6;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Listado de Planes del Sistema</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Duración</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($planes as $plan)
                <tr>
                    <td>{{ $plan->nomb_plan }}</td>
                    <td>{{ is_array($plan->descripcion) ? implode(', ', $plan->descripcion) : $plan->descripcion }}</td>
                    <td>${{ number_format($plan->valor, 0) }}</td>
                    <td>{{ $plan->duracion }} días</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
