<?php
declare(strict_types=1);

require __DIR__ . '/_base.php'; // define $BASE automáticamente
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title ?? 'Inventario') ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $BASE ?>/assets/styles.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?= $BASE ?>/public/index.php">Inventario 🧾</a>

    <div class="navbar-nav ms-auto gap-2 align-items-center">
      <button type="button" class="theme-toggle" onclick="toggleDarkMode()" id="themeBtn">
        🌙 Modo oscuro
      </button>

      <a class="nav-link" href="<?= $BASE ?>/public/productos.php">Productos</a>
      <a class="nav-link" href="<?= $BASE ?>/public/categorias.php">Categorías</a>
      <a class="nav-link" href="<?= $BASE ?>/public/proveedores.php">Proveedores</a>
    </div>
  </div>
</nav>

<div class="container py-4">
