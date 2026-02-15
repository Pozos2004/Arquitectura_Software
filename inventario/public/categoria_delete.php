<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/CategoriaRepository.php';

$BASE = "/arq_software/inventario";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: {$BASE}/public/categorias.php"); exit; }

$repo = new CategoriaRepository(Database::pdo());
$repo->delete($id);

header("Location: {$BASE}/public/categorias.php");
exit;
