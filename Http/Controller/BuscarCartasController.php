<?php

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\BuscarCartasService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;

class BuscarCartasController
{
    public function executar(array $query): array
    {
        $filtros = [
            'nome'     => trim($query['nomeCarta'] ?? ''),
            'edicao'   => (int) ($query['busca_edicao'] ?? 0),
            'raridade' => (int) ($query['busca_raridade'] ?? 0),
            'tipo'     => (int) ($query['busca_tipo'] ?? 0),
        ];

        $repository = new CartaRepositoryPDO();
        $service = new BuscarCartasService($repository);

        return $service->executar($filtros);
    }
}
