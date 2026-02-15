<?php
declare(strict_types=1);

final class ProveedorRepository {
  public function __construct(private PDO $pdo) {}

  public function all(): array {
    return $this->pdo->query("SELECT * FROM proveedores ORDER BY nombre")->fetchAll();
  }

  public function find(int $id): ?array {
    $st = $this->pdo->prepare("SELECT * FROM proveedores WHERE id=?");
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ?: null;
  }

  public function create(string $nombre, ?string $telefono, ?string $email, ?string $direccion): void {
    $st = $this->pdo->prepare("INSERT INTO proveedores(nombre, telefono, email, direccion) VALUES(?,?,?,?)");
    $st->execute([$nombre, $telefono, $email, $direccion]);
  }

  public function update(int $id, string $nombre, ?string $telefono, ?string $email, ?string $direccion): void {
    $st = $this->pdo->prepare("UPDATE proveedores SET nombre=?, telefono=?, email=?, direccion=? WHERE id=?");
    $st->execute([$nombre, $telefono, $email, $direccion, $id]);
  }

  public function delete(int $id): void {
    $st = $this->pdo->prepare("DELETE FROM proveedores WHERE id=?");
    $st->execute([$id]);
  }
}
