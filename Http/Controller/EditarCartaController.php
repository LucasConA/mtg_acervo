<?php

/* recebe o id, busca a carta e devolve os dados prontos para a view */

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\BuscarCartaService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;

class EditarCartaController
{
    public function executar(array $query): array
    {
        $id = filter_var($query['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $service = new BuscarCartaService(
            new CartaRepositoryPDO()
        );

        return $service->executar($id);
    }
}


?>