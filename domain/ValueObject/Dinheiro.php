<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

class Dinheiro
{
    private float $valor;

    public function __construct(float $valor)
    {
        if ($valor < 0) {
            throw new InvalidArgumentException('Valor não pode ser negativo');
        }

        // normaliza para 2 casas decimais
        $this->valor = round($valor, 2);
    }

    public function valor(): float
    {
        return $this->valor;
    }
}
