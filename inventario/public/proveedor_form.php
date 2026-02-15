<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProveedorRepository.php';

$BASE = "/arq_software/inventario";

$repo = new ProveedorRepository(Database::pdo());

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$row = ['nombre'=>'','telefono'=>'','email'=>'','direccion'=>''];
if ($editing) {
  $found = $repo->find($id);
  if (!$found) { http_response_code(404); exit("Proveedor no encontrado"); }
  $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $telefono = trim($_POST['telefono'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $direccion = trim($_POST['direccion'] ?? '');

  if ($nombre === '') $errors[] = "Nombre es obligatorio.";

  if (!$errors) {
    if ($editing) $repo->update($id, $nombre, $telefono ?: null, $email ?: null, $direccion ?: null);
    else $repo->create($nombre, $telefono ?: null, $email ?: null, $direccion ?: null);

    header("Location: {$BASE}/public/proveedores.php");
    exit;
  }

  $row = compact('nombre','telefono','email','direccion');
}

$title = $editing ? "Editar proveedor" : "Nuevo proveedor";
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
      <label class="form-label">Teléfono</label>
      <input class="form-control" name="telefono" value="<?= htmlspecialchars((string)($row['telefono'] ?? '')) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?= htmlspecialchars((string)($row['email'] ?? '')) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Dirección</label>
      <input class="form-control" name="direccion" value="<?= htmlspecialchars((string)($row['direccion'] ?? '')) ?>">
    </div>
    <div class="col-12 d-flex gap-2">
      <button class="btn btn-light" type="submit">Guardar</button>
      <a class="btn btn-outline-light" href="<?= $BASE ?>/public/proveedores.php">Cancelar</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
