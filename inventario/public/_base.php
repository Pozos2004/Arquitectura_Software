<?php
declare(strict_types=1);

// Detecta automáticamente la carpeta base del proyecto
// Ej: /arq_software/inventario/public/productos.php  ->  /arq_software/inventario
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // /arq_software/inventario/public
$BASE = preg_replace('#/public$#', '', $scriptDir); // /arq_software/inventario
