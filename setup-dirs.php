<?php

/**
 * Setup de directorios y vistas para admin
 */

$baseDir = __DIR__;
$dirs = [
    'resources/views/admin/grupos',
    'resources/views/admin/docentes',
    'resources/views/admin/carreras',
    'resources/views/admin/requisitos',
];

foreach ($dirs as $dir) {
    $fullPath = $baseDir . DIRECTORY_SEPARATOR . $dir;
    if (!is_dir($fullPath)) {
        @mkdir($fullPath, 0755, true);
        file_put_contents($fullPath . '/.gitkeep', '');
    }
}

echo "✓ Directorios creados correctamente\n";
