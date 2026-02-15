<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProductoRepository.php';
require_once __DIR__ . '/../src/app/ProductService.php';

require __DIR__ . '/_base.php'; // $BASE

$pdo = Database::pdo();
$repo = new ProductoRepository($pdo);
$service = new ProductService($repo);

$productos = $service->listWithDomainFlag();

$title = "Productos";
require __DIR__ . '/_layout_top.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 mb-0">Productos</h1>
  <a class="btn btn-light" href="<?= $BASE ?>/public/producto_form.php">+ Nuevo</a>
</div>

<div class="card p-3">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>SKU</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Proveedor</th>
          <th class="text-end">Precio</th>
          <th class="text-end">Stock</th>
          <th class="text-end">Mínimo</th>
          <th>Estado</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['sku']) ?></td>
          <td>
            <?= htmlspecialchars($p['nombre']) ?>
            <?php if (!empty($p['needs_restock'])): ?>
              <span class="badge bg-warning text-dark ms-2">Reabastecer</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($p['categoria']) ?></td>
          <td><?= htmlspecialchars($p['proveedor'] ?? '-') ?></td>
          <td class="text-end">$<?= number_format((float)$p['precio'], 2) ?></td>
          <td class="text-end"><?= (int)$p['stock'] ?></td>
          <td class="text-end"><?= (int)$p['stock_minimo'] ?></td>
          <td>
            <?php if ((int)$p['activo'] === 1): ?>
              <span class="badge badge-soft">Activo</span>
            <?php else: ?>
              <span class="badge bg-secondary">Inactivo</span>
            <?php endif; ?>
          </td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-light"
               href="<?= $BASE ?>/public/producto_form.php?id=<?= (int)$p['id'] ?>">Editar</a>

            <a class="btn btn-sm btn-outline-danger"
               href="<?= $BASE ?>/public/producto_delete.php?id=<?= (int)$p['id'] ?>"
               onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>

    </table>
  </div>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
