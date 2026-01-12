<?php
/* --- só executa regra de negócio --- */

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class AtualizarCartaService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(Carta $carta): void
    {
        $this->repository->atualizar($carta);
    }
}
?>