<?php
declare(strict_types=1);

final class Producto {
  public function __construct(
    public int $id,
    public string $sku,
    public string $nombre,
    public int $stock,
    public int $stockMinimo,
    public bool $activo
  ) {}

  public function necesitaReabastecimiento(): bool {
    if (!$this->activo) return false;
    return $this->stock <= $this->stockMinimo;
  }
}
