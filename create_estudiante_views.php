<?php
// Script para crear carpeta y archivos Blade
$basePath = 'c:\\xampp\\htdocs\\cup-ficct-uagrm\\resources\\views\\estudiante';

// Crear carpeta
if (!is_dir($basePath)) {
    if (!mkdir($basePath, 0755, true)) {
        echo "Error: No se pudo crear la carpeta\n";
        exit(1);
    }
    echo "✓ Carpeta creada: $basePath\n";
} else {
    echo "✓ Carpeta ya existe: $basePath\n";
}

// Contenido placeholder para los archivos
$placeholderContent = "@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='card'>
                <div class='card-header'>Sección de Estudiante</div>
                <div class='card-body'>
                    <p>Contenido a desarrollar</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
";

// Nombres de archivos a crear
$files = [
    'dashboard.blade.php',
    'horario.blade.php',
    'materias-inscritas.blade.php',
    'docentes-lista.blade.php',
    'cup-info.blade.php'
];

// Crear archivos
$createdCount = 0;
foreach ($files as $filename) {
    $filePath = $basePath . DIRECTORY_SEPARATOR . $filename;
    if (file_put_contents($filePath, $placeholderContent)) {
        echo "✓ Archivo creado: $filename\n";
        $createdCount++;
    } else {
        echo "✗ Error creando: $filename\n";
    }
}

echo "\n--- Verificación ---\n";
echo "Archivos creados: $createdCount/5\n\n";

// Listar archivos
$scanResult = array_diff(scandir($basePath), ['.', '..']);
if ($scanResult) {
    echo "Archivos en la carpeta:\n";
    foreach ($scanResult as $file) {
        if (strpos($file, '.blade.php') !== false) {
            echo "  ✓ $file\n";
        }
    }
} else {
    echo "No se encontraron archivos\n";
}

echo "\nProceso completado.\n";
?>
