<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProductoRepository.php';
require_once __DIR__ . '/../src/infra/repositories/CategoriaRepository.php';
require_once __DIR__ . '/../src/infra/repositories/ProveedorRepository.php';

require __DIR__ . '/_base.php'; // <- $BASE automático

$pdo = Database::pdo();
$prodRepo = new ProductoRepository($pdo);

$totalProductos   = (int)$pdo->query("SELECT COUNT(*) c FROM productos")->fetch()['c'];
$totalCategorias  = (int)$pdo->query("SELECT COUNT(*) c FROM categorias")->fetch()['c'];
$totalProveedores = (int)$pdo->query("SELECT COUNT(*) c FROM proveedores")->fetch()['c'];

$low = $prodRepo->lowStock();
$totalLow = count($low);

$title = "Dashboard";
require __DIR__ . '/_layout_top.php';
?>

<h1 class="h3 mb-3">Dashboard</h1>

<div class="row g-3 mb-3">
  <div class="col-md-3">
    <div class="card p-3">
      <div class="text-secondary">Productos</div>
      <div class="display-6"><?= $totalProductos ?></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3">
      <div class="text-secondary">Stock bajo</div>
      <div class="display-6"><?= $totalLow ?></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3">
      <div class="text-secondary">Categorías</div>
      <div class="display-6"><?= $totalCategorias ?></div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3">
      <div class="text-secondary">Proveedores</div>
      <div class="display-6"><?= $totalProveedores ?></div>
    </div>
  </div>
</div>

<div class="card p-3">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h2 class="h5 mb-0">Productos con stock bajo</h2>

    <!-- AQUÍ estaba el error: ahora usa $BASE -->
    <a class="btn btn-sm btn-outline-light" href="<?= $BASE ?>/public/productos.php">
      Ver productos
    </a>
  </div>

  <?php if (!$low): ?>
    <div class="text-secondary">Todo en orden. El almacén ronronea 🐱</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>SKU</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th class="text-end">Stock</th>
            <th class="text-end">Mínimo</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($low as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['sku']) ?></td>
              <td><?= htmlspecialchars($p['nombre']) ?></td>
              <td><?= htmlspecialchars($p['categoria']) ?></td>
              <td class="text-end"><?= (int)$p['stock'] ?></td>
              <td class="text-end"><?= (int)$p['stock_minimo'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
