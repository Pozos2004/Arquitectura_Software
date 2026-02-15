<?php
declare(strict_types=1);

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); 
$BASE = preg_replace('#/public$#', '', $scriptDir); 
