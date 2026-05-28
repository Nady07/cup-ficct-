<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Grupos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #0891b2; margin-bottom: 5px; }
        .fecha { text-align: center; color: #666; margin-bottom: 15px; }
        .resumen { background: #ecfeff; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #0891b2; color: white; padding: 8px 6px; text-align: center; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; text-align: center; }
    </style>
</head>
<body>
    <h1>🏫 CUP FICCT - Reporte de Grupos</h1>
    <p class="fecha">Generado: {{ date('d/m/Y H:i') }}</p>
    
    <div class="resumen">
        <strong>Resumen:</strong>
        Total inscritos: {{ $resumen['total_inscritos'] }} | 
        Grupos actuales: {{ $resumen['grupos_actuales'] }} | 
        Grupos necesarios: {{ $resumen['grupos_necesarios'] }} | 
        Cupos disponibles: {{ $resumen['cupos_disponibles'] }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Turno</th>
                <th>Horario</th>
                <th>Docente</th>
                <th>Inscritos</th>
                <th>Capacidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grupos as $g)
            <tr>
                <td>{{ $g->codigo }}</td>
                <td>{{ $g->turno === 'M' ? 'Mañana' : ($g->turno === 'T' ? 'Tarde' : 'Noche') }}</td>
                <td>{{ $g->horario_inicio }} - {{ $g->horario_fin }}</td>
                <td>{{ $g->docente->apellidos ?? '—' }}</td>
                <td>{{ $g->inscripciones_count }}</td>
                <td>{{ $g->capacidad_maxima }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>