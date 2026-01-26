<?php

namespace App\AcervoMtg\Domain\Entity;

use App\AcervoMtg\Domain\ValueObject\Quantidade;
use App\AcervoMtg\Domain\ValueObject\Dinheiro;
use App\AcervoMtg\Domain\ValueObject\Raridade;
use App\AcervoMtg\Domain\ValueObject\Condicao;
use App\AcervoMtg\Domain\ValueObject\Idioma;
use App\AcervoMtg\Domain\ValueObject\Tipo;

class Carta
{
    public function __construct(
        public int $id,
        public string $nome,
        public int $edicao,
        public Raridade $raridade,
        public Condicao $condicao,
        public Idioma $idioma,
        public Tipo $tipo,
        public bool $foil,
        public Quantidade $quantidade,
        public Dinheiro $valor
    ) {}
}
