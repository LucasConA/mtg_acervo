<?php
namespace App\AcervoMtg\Domain\Entity;

/* Declara a classe carta */

class Carta
{
    public function __construct(
        public int $id,
        public string $nome,
        public int $edicao,
        public int $raridade,
        public int $condicao,
        public int $idioma,
        public int $tipo,
        public bool $foil,
        public int $quantidade,
        public float $valor
    ) {}
}
