<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/ProveedorRepository.php';

require __DIR__ . '/_base.php'; // $BASE

$repo = new ProveedorRepository(Database::pdo());
$rows = $repo->all();

$title = "Proveedores";
require __DIR__ . '/_layout_top.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 mb-0">Proveedores</h1>
  <a class="btn btn-light" href="<?= $BASE ?>/public/proveedor_form.php">+ Nuevo</a>
</div>

<div class="card p-3">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Dirección</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td class="text-secondary"><?= htmlspecialchars($r['telefono'] ?? '') ?></td>
          <td class="text-secondary"><?= htmlspecialchars($r['email'] ?? '') ?></td>
          <td class="text-secondary"><?= htmlspecialchars($r['direccion'] ?? '') ?></td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-light"
               href="<?= $BASE ?>/public/proveedor_form.php?id=<?= (int)$r['id'] ?>">Editar</a>

            <a class="btn btn-sm btn-outline-danger"
               href="<?= $BASE ?>/public/proveedor_delete.php?id=<?= (int)$r['id'] ?>"
               onclick="return confirm('¿Eliminar proveedor?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>

    </table>
  </div>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
