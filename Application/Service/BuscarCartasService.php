<?php

/* faz a busca com filtros */

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class BuscarCartasService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(array $filtros): array
    {
        return $this->repository->buscarComFiltros($filtros);
    }
}
