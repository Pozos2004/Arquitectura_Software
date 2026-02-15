<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/infra/Database.php';
require_once __DIR__ . '/../src/infra/repositories/CategoriaRepository.php';

require __DIR__ . '/_base.php'; // $BASE

$repo = new CategoriaRepository(Database::pdo());
$rows = $repo->all();

$title = "Categorías";
require __DIR__ . '/_layout_top.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h3 mb-0">Categorías</h1>
  <a class="btn btn-light" href="<?= $BASE ?>/public/categoria_form.php">+ Nueva</a>
</div>

<div class="card p-3">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['nombre']) ?></td>
          <td class="text-secondary"><?= htmlspecialchars($r['descripcion'] ?? '') ?></td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-light"
               href="<?= $BASE ?>/public/categoria_form.php?id=<?= (int)$r['id'] ?>">Editar</a>

            <a class="btn btn-sm btn-outline-danger"
               href="<?= $BASE ?>/public/categoria_delete.php?id=<?= (int)$r['id'] ?>"
               onclick="return confirm('Si eliminas la categoría, productos asociados pueden fallar por llave foránea. ¿Continuar?');">
              Eliminar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>

    </table>
  </div>
</div>

<?php require __DIR__ . '/_layout_bottom.php'; ?>
