<?php
declare(strict_types=1);

final class CategoriaRepository {
  public function __construct(private PDO $pdo) {}

  public function all(): array {
    return $this->pdo->query("SELECT * FROM categorias ORDER BY nombre")->fetchAll();
  }

  public function find(int $id): ?array {
    $st = $this->pdo->prepare("SELECT * FROM categorias WHERE id=?");
    $st->execute([$id]);
    $row = $st->fetch();
    return $row ?: null;
  }

  public function create(string $nombre, ?string $descripcion): void {
    $st = $this->pdo->prepare("INSERT INTO categorias(nombre, descripcion) VALUES(?, ?)");
    $st->execute([$nombre, $descripcion]);
  }

  public function update(int $id, string $nombre, ?string $descripcion): void {
    $st = $this->pdo->prepare("UPDATE categorias SET nombre=?, descripcion=? WHERE id=?");
    $st->execute([$nombre, $descripcion, $id]);
  }

  public function delete(int $id): void {
    $st = $this->pdo->prepare("DELETE FROM categorias WHERE id=?");
    $st->execute([$id]);
  }
}
