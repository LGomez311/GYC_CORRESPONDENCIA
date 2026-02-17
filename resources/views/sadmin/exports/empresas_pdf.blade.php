<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Empresas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; font-size: 12px; }
        th { background-color: #f3f4f6; }
        h2 { text-align: center; }
    </style>
</head>
<body>

    <h2>Listado de Empresas</h2>

    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>NIT</th>
                <th>Plan Actual</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->nomb_empresa }}</td>
                    <td>{{ $empresa->nit_empresa }}</td>
                    <td>{{ optional($empresa->plan)->nomb_plan ?? 'Sin plan' }}</td>
                    <td>{{ $empresa->direccion }}</td>
                    <td>{{ $empresa->contacto }}</td>
                    <td>{{ $empresa->empresa_correo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
