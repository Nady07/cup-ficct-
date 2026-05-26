<?php
// Este script se ejecuta cuando se accede vía HTTP
// Crea la carpeta y los archivos necesarios

$baseDir = __DIR__ . '/resources/views/estudiante';

// Crear directorio
if (!is_dir($baseDir)) {
    @mkdir($baseDir, 0777, true);
}

// Contenido de los archivos Blade
$content = "@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='card'>
                <div class='card-header'>Panel de Estudiante</div>
                <div class='card-body'>
                    <p>Contenido a desarrollar</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
";

// Archivos a crear
$files = [
    'dashboard.blade.php',
    'horario.blade.php',
    'materias-inscritas.blade.php',
    'docentes-lista.blade.php',
    'cup-info.blade.php'
];

$created = [];
$errors = [];

foreach ($files as $filename) {
    $filepath = $baseDir . '/' . $filename;
    if (@file_put_contents($filepath, $content)) {
        $created[] = $filename;
    } else {
        $errors[] = $filename;
    }
}

// Mostrar resultado
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Archivos Blade</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .success { color: green; }
        .error { color: red; }
        h1 { color: #333; }
        ul { margin: 10px 0; }
        li { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Creación de Archivos Blade - Estudiante</h1>
        
        <h2>Carpeta: <code><?php echo str_replace('\\', '/', $baseDir); ?></code></h2>
        
        <?php if (is_dir($baseDir)): ?>
            <p class="success"><strong>✓ Carpeta existe y es accesible</strong></p>
        <?php else: ?>
            <p class="error"><strong>✗ Error: No se pudo crear/acceder la carpeta</strong></p>
        <?php endif; ?>
        
        <h3>Archivos Creados: <span class="success"><?php echo count($created); ?>/5</span></h3>
        <ul>
            <?php foreach ($created as $file): ?>
                <li class="success">✓ <code><?php echo $file; ?></code></li>
            <?php endforeach; ?>
        </ul>
        
        <?php if (!empty($errors)): ?>
            <h3>Errores: <span class="error"><?php echo count($errors); ?></span></h3>
            <ul>
                <?php foreach ($errors as $file): ?>
                    <li class="error">✗ <code><?php echo $file; ?></code></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <h3>Archivos en la carpeta:</h3>
        <ul>
            <?php 
            if (is_dir($baseDir)) {
                $files = array_diff(scandir($baseDir), ['.', '..']);
                if (empty($files)) {
                    echo "<li>Carpeta vacía</li>";
                } else {
                    foreach ($files as $file) {
                        if (strpos($file, '.blade.php') !== false) {
                            echo "<li class='success'>✓ " . htmlspecialchars($file) . "</li>";
                        }
                    }
                }
            }
            ?>
        </ul>
    </div>
</body>
</html>
