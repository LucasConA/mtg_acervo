<?php

namespace App\AcervoMtg\Domain\ValueObject;

use InvalidArgumentException;

final class Idioma
{
    private const IDIOMAS = [
        1  => 'Alemão',
        2  => 'Chinês Simplificado',
        3  => 'Chinês Tradicional',
        4  => 'Coreano',
        5  => 'Espanhol',
        6  => 'Francês',
        7  => 'Inglês',
        8  => 'Italiano',
        9  => 'Japonês',
        10 => 'Português',
        11 => 'Russo',
    ];

    public function __construct(
        private int $valor
    ) {
        if (!array_key_exists($valor, self::IDIOMAS)) {
            throw new InvalidArgumentException('Idioma inválido');
        }
    }

    public function valor(): int
    {
        return $this->valor;
    }

    public function nome(): string
    {
        return self::IDIOMAS[$this->valor];
    }
}
