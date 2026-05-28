<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Postulantes Aprobados</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #16a34a; margin-bottom: 5px; }
        .fecha { text-align: center; color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #16a34a; color: white; padding: 8px 6px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; }
        .total { margin-top: 15px; font-weight: bold; color: #16a34a; }
    </style>
</head>
<body>
    <h1>🎓 CUP FICCT - Postulantes Aprobados</h1>
    <p class="fecha">Generado: {{ date('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>CI</th>
                <th>Promedio</th>
                <th>Grupo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aprobados as $index => $e)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $e->apellidos }} {{ $e->nombre }}</td>
                <td>{{ $e->ci }}</td>
                <td>{{ number_format($e->promedio(), 1) }}</td>
                <td>{{ $e->inscripcion->grupo->codigo ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p class="total">Total aprobados: {{ $aprobados->count() }}</p>
</body>
</html>