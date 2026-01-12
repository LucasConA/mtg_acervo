<?php
namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class ListarCartasService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(?string $ordem = null): array
    {
        $cartas = $this->repository->listar($ordem);

        $total = 0.0;
        foreach ($cartas as $carta) {
            $total += $carta->valor * $carta->quantidade;
        }

        return [
            'cartas' => $cartas,
            'total'  => $total
        ];
    }
}
