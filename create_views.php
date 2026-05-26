<?php

$basePath = 'c:\\xampp\\htdocs\\cup-ficct-uagrm\\resources\\views\\estudiante';

// Crear carpeta si no existe
if (!is_dir($basePath)) {
    mkdir($basePath, 0755, true);
}

// Crear archivos vacíos o con placeholder
$files = [
    'dashboard.blade.php',
    'horario.blade.php',
    'materias-inscritas.blade.php',
    'docentes-lista.blade.php',
    'cup-info.blade.php'
];

foreach ($files as $file) {
    $path = $basePath . '\\' . $file;
    if (!file_exists($path)) {
        file_put_contents($path, "<!-- Placeholder for {$file} -->\n");
    }
}

echo "Carpeta y archivos creados en: {$basePath}\n";
echo "Archivos creados:\n";
foreach ($files as $file) {
    echo "  - {$file}\n";
}
?>
