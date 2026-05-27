<?php
// Crear directorio de grupos
$dir = 'resources/views/admin/grupos';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
    echo "Directorio creado: $dir\n";
}
?>