<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

class Quantidade
{
    private int $valor;

    public function __construct(int $valor)
    {
        if ($valor < 0) {
            throw new InvalidArgumentException('Quantidade não pode ser negativa');
        }

        $this->valor = $valor;
    }

    public function valor(): int
    {
        return $this->valor;
    }
}
