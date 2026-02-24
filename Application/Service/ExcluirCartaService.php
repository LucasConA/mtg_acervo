<?php
namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class ExcluirCartaService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(int $id): void
    {
        $this->repository->excluir($id);
    }
}
?>