<?php

namespace App\AcervoMtg\Domain\Exception;

use RuntimeException;

class CartaNaoEncontradaException extends RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct("Carta com ID {$id} não encontrada");
    }
}
