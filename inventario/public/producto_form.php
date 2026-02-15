<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProductoRepository.php';
require_once __DIR__ . '/../src/infra/repositories/CategoriaRepository.php';
require_once __DIR__ . '/../src/infra/repositories/ProveedorRepository.php';

$BASE = "/arq_software/inventario";

$pdo = Database::pdo();
$prodRepo = new ProductoRepository($pdo);
$catRepo = new CategoriaRepository($pdo);
$provRepo = new ProveedorRepository($pdo);

$categorias = $catRepo->all();
$proveedores = $provRepo->all();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$producto = [
  'sku' => '',
  'nombre' => '',
  'descripcion' => '',
  'categoria_id' => $categorias[0]['id'] ?? 0,
  'proveedor_id' => '',
  'precio' => '0.00',
  'stock' => '0',
  'stock_minimo' => '0',
  'activo' => 1,
];

if ($editing) {
  $row = $prodRepo->find($id);
  if (!$row) { http_response_code(404); exit("Producto no encontrado"); }
  $producto = array_merge($producto, $row);
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'sku' => trim($_POST['sku'] ?? ''),
    'nombre' => trim($_POST['nombre'] ?? ''),
    'descripcion' => trim($_POST['descripcion'] ?? ''),
    'categoria_id' => $_POST['categoria_id'] ?? '',
    'proveedor_id' => $_POST['proveedor_id'] ?? '',
    'precio' => $_POST['precio'] ?? '0',
    'stock' => $_POST['stock'] ?? '0',
    'stock_minimo' => $_POST['stock_minimo'] ?? '0',
    'activo' => isset($_POST['activo']) ? 1 : 0,
  ];

  if ($data['sku'] === '') $errors[] = "SKU es obligatorio.";
  if ($data['nombre'] === '') $errors[] = "Nombre es obligatorio.";
  if ((int)$data['categoria_id'] <= 0) $errors[] = "Selecciona una categoría.";

  if (!$errors) {
    if ($editing) $prodRepo->update($id, $data);
    else $prodRepo->create($data);

    header("Location: {$BASE}/public/productos.php");
    exit;
  }

  $producto = array_merge($producto, $data);
}

$title = $editing ? "Editar producto" : "Nuevo producto";
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
    <div class="col-md-4">
      <label class="form-label">SKU</label>
      <input class="form-control" name="sku" value="<?= htmlspecialchars((string)$producto['sku']) ?>" required>
    </div>

    <div class="col-md-8">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="nombre" value="<?= htmlspecialchars((string)$producto['nombre']) ?>" required>
    </div>

    <div class="col-12">
      <label class="form-label">Descripción</label>
      <input class="form-control" name="descripcion" value="<?= htmlspecialchars((string)$producto['descripcion']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Categoría</label>
      <select class="form-select" name="categoria_id" required>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= ((int)$producto['categoria_id'] === (int)$c['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Proveedor (opcional)</label>
      <select class="form-select" name="proveedor_id">
        <option value="">Sin proveedor</option>
        <?php foreach ($proveedores as $pr): ?>
          <option value="<?= (int)$pr['id'] ?>" <?= ((string)$producto['proveedor_id'] === (string)$pr['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($pr['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Precio</label>
      <input type="number" step="0.01" min="0" class="form-control" name="precio" value="<?= htmlspecialchars((string)$producto['precio']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Stock</label>
      <input type="number" min="0" class="form-control" name="stock" value="<?= htmlspecialchars((string)$producto['stock']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Stock mínimo</label>
      <input type="number" min="0" class="form-control" name="stock_minimo" value="<?= htmlspecialchars((string)$producto['stock_minimo']) ?>">
    </div>

    <div class="col-md-4 d-flex align-items-end">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="activo" id="activo" <?= ((int)$producto['activo'] === 1) ? 'checked' : '' ?>>
        <label class="form-check-label" for="activo">Activo</label>
      </div>
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-light" type="submit">Guardar</button>
      <a class="btn btn-outline-light" href="<?= $BASE ?>/public/productos.php">Cancelar</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
