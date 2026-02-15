<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProveedorRepository.php';

$BASE = "/arq_software/inventario";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: {$BASE}/public/proveedores.php"); exit; }

$repo = new ProveedorRepository(Database::pdo());
$repo->delete($id);

header("Location: {$BASE}/public/proveedores.php");
exit;
