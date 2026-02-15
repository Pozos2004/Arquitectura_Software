<?php
declare(strict_types=1);

final class ProductoRepository {
  public function __construct(private PDO $pdo) {}

  public function all(): array {
    $sql = "SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor
            FROM productos p
            JOIN categorias c ON c.id = p.categoria_id
            LEFT JOIN proveedores pr ON pr.id = p.proveedor_id
            ORDER BY p.nombre";
    return $this->pdo->query($sql)->fetchAll();
  }

  public function lowStock(): array {
    $sql = "SELECT p.*, c.nombre AS categoria
            FROM productos p
            JOIN categorias c ON c.id = p.categoria_id
            WHERE p.activo=1 AND p.stock <= p.stock_minimo
            ORDER BY (p.stock - p.stock_minimo) ASC, p.nombre";
    return $this->pdo->query($sql)->fetchAll();
  }

  public function find(int $id): ?array {
    $st = $this->pdo->prepare("SELECT * FROM productos WHERE id=?");
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ?: null;
  }

  public function create(array $d): void {
    $sql = "INSERT INTO productos(sku,nombre,descripcion,categoria_id,proveedor_id,precio,stock,stock_minimo,activo)
            VALUES(?,?,?,?,?,?,?,?,?)";
    $st = $this->pdo->prepare($sql);
    $st->execute([
      $d['sku'], $d['nombre'], $d['descripcion'],
      (int)$d['categoria_id'],
      $d['proveedor_id'] !== '' ? (int)$d['proveedor_id'] : null,
      (float)$d['precio'], (int)$d['stock'], (int)$d['stock_minimo'],
      (int)$d['activo']
    ]);
  }

  public function update(int $id, array $d): void {
    $sql = "UPDATE productos
            SET sku=?, nombre=?, descripcion=?, categoria_id=?, proveedor_id=?, precio=?, stock=?, stock_minimo=?, activo=?
            WHERE id=?";
    $st = $this->pdo->prepare($sql);
    $st->execute([
      $d['sku'], $d['nombre'], $d['descripcion'],
      (int)$d['categoria_id'],
      $d['proveedor_id'] !== '' ? (int)$d['proveedor_id'] : null,
      (float)$d['precio'], (int)$d['stock'], (int)$d['stock_minimo'],
      (int)$d['activo'],
      $id
    ]);
  }

  public function delete(int $id): void {
    $st = $this->pdo->prepare("DELETE FROM productos WHERE id=?");
    $st->execute([$id]);
  }
}
