<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Empresas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; font-size: 11px; }
        th { background-color: #f3f4f6; }
        h2 { text-align: center; margin-bottom: 5px; }
        .fecha { text-align: right; font-size: 10px; margin-bottom: 10px; }
        .footer { margin-top: 10px; font-size: 10px; text-align: right; }
    </style>
</head>
<body>

    <h2>Listado de Empresas</h2>
    <div class="fecha">
        Fecha de generación: {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Empresa</th>
                <th>NIT</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Doc. Representante</th>
                <th>Representante</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->nomb_empresa }}</td>
                    <td>{{ $empresa->nit_empresa }}</td>
                    <td>{{ $empresa->direccion ?? '—' }}</td>
                    <td>{{ $empresa->contacto ?? '—' }}</td>
                    <td>{{ $empresa->empresa_correo }}</td>
                    <td>{{ $empresa->doc_representante }}</td>
                    <td>{{ $empresa->nomb_representante }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total de empresas: {{ $empresas->count() }}
    </div>

</body>
</html>