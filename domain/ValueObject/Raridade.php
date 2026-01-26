<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

final class Raridade
{
    private const VALIDAS = [
        1 => 'Comum',
        2 => 'Incomum',
        3 => 'Rara',
        4 => 'Mítica',
    ];

    private int $valor;

    public function __construct(int $valor)
    {
        if (!array_key_exists($valor, self::VALIDAS)) {
            throw new InvalidArgumentException('Raridade inválida');
        }

        $this->valor = $valor;
    }

    public function valor(): int
    {
        return $this->valor;
    }

    public function nome(): string
    {
        return self::VALIDAS[$this->valor];
    }
}
