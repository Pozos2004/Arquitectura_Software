<?php
declare(strict_types=1);

require_once __DIR__ . '/../domain/Producto.php';

final class ProductService {
  public function __construct(private ProductoRepository $repo) {}

  public function listWithDomainFlag(): array {
    $rows = $this->repo->all();
    foreach ($rows as &$r) {
      $p = new Producto(
        (int)$r['id'],
        (string)$r['sku'],
        (string)$r['nombre'],
        (int)$r['stock'],
        (int)$r['stock_minimo'],
        (bool)$r['activo']
      );
      $r['needs_restock'] = $p->necesitaReabastecimiento();
    }
    return $rows;
  }
}
