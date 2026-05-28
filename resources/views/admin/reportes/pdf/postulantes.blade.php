<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Postulantes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #1a56db; margin-bottom: 5px; }
        .fecha { text-align: center; color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a56db; color: white; padding: 8px 6px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .total { margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>CUP FICCT - Lista General de Postulantes</h1>
    <p class="fecha">Generado: {{ date('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Apellidos y Nombres</th>
                <th>CI</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $index => $e)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $e->apellidos }} {{ $e->nombre }}</td>
                <td>{{ $e->ci }}</td>
                <td>{{ $e->carreraInteres->nombre ?? '—' }}</td>
                <td>{{ $e->inscripcion->grupo->codigo ?? '—' }}</td>
                <td>{{ $e->inscripcion->estado ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p class="total">Total: {{ $estudiantes->count() }} postulantes</p>
</body>
</html>