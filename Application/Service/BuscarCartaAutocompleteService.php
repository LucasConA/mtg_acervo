<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class BuscarCartaAutocompleteService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(string $termo): array
    {
        if (mb_strlen($termo) < 2) {
            return [];
        }

        return $this->repository->buscarNomesPorTermo($termo);
    }
}
