<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/CategoriaRepository.php';

$BASE = "/arq_software/inventario";

$repo = new CategoriaRepository(Database::pdo());

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$row = ['nombre' => '', 'descripcion' => ''];
if ($editing) {
  $found = $repo->find($id);
  if (!$found) { http_response_code(404); exit("Categoría no encontrada"); }
  $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $descripcion = trim($_POST['descripcion'] ?? '');

  if ($nombre === '') $errors[] = "Nombre es obligatorio.";

  if (!$errors) {
    if ($editing) $repo->update($id, $nombre, $descripcion ?: null);
    else $repo->create($nombre, $descripcion ?: null);

    header("Location: {$BASE}/public/categorias.php");
    exit;
  }

  $row = ['nombre' => $nombre, 'descripcion' => $descripcion];
}

$title = $editing ? "Editar categoría" : "Nueva categoría";
require __DIR__ . '/_layout_top.php';
?>

<h1 class="h3 mb-3"><?= htmlspecialchars($title) ?></h1>

<?php if ($errors): ?>
  <div class="alert alert-warning">
    <ul class="mb-0">
      <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card p-3">
  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="nombre" value="<?= htmlspecialchars((string)$row['nombre']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion" value="<?= htmlspecialchars((string)($row['descripcion'] ?? '')) ?>">
    </div>
    <div class="col-12 d-flex gap-2">
      <button class="btn btn-light" type="submit">Guardar</button>
      <a class="btn btn-outline-light" href="<?= $BASE ?>/public/categorias.php">Cancelar</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
