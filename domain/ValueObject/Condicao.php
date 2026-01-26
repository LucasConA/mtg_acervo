<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

final class Condicao
{
    private const CONDICOES = [
        1 => 'Mint',
        2 => 'Near Mint',
        3 => 'Slightly Played',
        4 => 'Moderately Played',
        5 => 'Heavily Played',
        6 => 'Damaged',
    ];

    public function __construct(
        private int $valor
    ) {
        if (!array_key_exists($valor, self::CONDICOES)) {
            throw new InvalidArgumentException('Condição inválida');
        }
    }

    public function valor(): int
    {
        return $this->valor;
    }

    public function nome(): string
    {
        return self::CONDICOES[$this->valor];
    }
}
