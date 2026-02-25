<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Listado de Administradores</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        .fecha { text-align: right; font-size: 10px; margin-bottom: 10px; }
        .footer { margin-top: 10px; font-size: 10px; text-align: right; }
    </style>
</head>

<body>

    <h2>Listado de Administradores de Empresa</h2>
    <div class="fecha">
        Fecha de generación: {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Empresa</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
            <tr>
                <td>{{ $admin->emple_doc }}</td>
                <td>{{ $admin->emple_nombres }}</td>
                <td>{{ $admin->emple_apellidos }}</td>
                <td>{{ $admin->empresa->nomb_empresa ?? '' }}</td>
                <td>{{ $admin->emple_correo }}</td>
                <td>{{ $admin->emple_tel }}</td>
                <td>{{ $admin->estado->estado_nomb ?? '' }}</td>
                <td>{{ $admin->rol->rol_nom ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total de Administradores {{ $admins->count() }}
    </div>

</body>

</html>