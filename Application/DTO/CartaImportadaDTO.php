<?php
namespace App\AcervoMtg\Application\DTO;

class CartaImportadaDTO
{
    public function __construct(
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
