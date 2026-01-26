<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

final class Tipo
{
    private const TIPOS = [
        1 => 'Artefato',
        2 => 'Criatura',
        3 => 'Criatura-artefato',
        4 => 'Criatura-encantamento',
        5 => 'Encantamento',
        6 => 'Feitiço',
        7 => 'Instantânea',
        8 => 'Planeswalker',
        9 => 'Terreno',
        10 => 'Tribal',
    ];

    public function __construct(
        private int $valor
    ) {
        if (!array_key_exists($valor, self::TIPOS)) {
            throw new InvalidArgumentException('Tipo inválido');
        }
    }

    public function valor(): int
    {
        return $this->valor;
    }

    public function nome(): string
    {
        return self::TIPOS[$this->valor];
    }
}
