<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Estadísticas por Materia</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #7c3aed; margin-bottom: 5px; }
        .fecha { text-align: center; color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background: #7c3aed; color: white; padding: 8px 6px; text-align: center; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; text-align: center; }
        .materia-title { background: #f3e8ff; font-weight: bold; text-align: left; }
    </style>
</head>
<body>
    <h1>📊 CUP FICCT - Estadísticas por Materia</h1>
    <p class="fecha">Generado: {{ date('d/m/Y H:i') }}</p>
    
    @foreach($materias as $m)
    <table>
        <tr><th colspan="2" class="materia-title">{{ $m->nombre }} ({{ $m->codigo }})</th></tr>
        <tr><td>Total evaluados</td><td>{{ $m->total_evaluados }}</td></tr>
        <tr><td>Aprobados</td><td>{{ $m->total_aprobados }} ({{ $m->porcentaje_aprobados }}%)</td></tr>
        <tr><td>Reprobados</td><td>{{ $m->total_reprobados }}</td></tr>
        <tr><td>Promedio general</td><td>{{ number_format($m->promedio_notas, 1) }}</td></tr>
        <tr><td>Nota más alta</td><td>{{ number_format($m->nota_mas_alta, 1) }}</td></tr>
        <tr><td>Nota más baja</td><td>{{ number_format($m->nota_mas_baja, 1) }}</td></tr>
    </table>
    @endforeach
</body>
</html>