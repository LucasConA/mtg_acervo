<?php

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\BuscarCartaAutocompleteService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;

class BuscarCartaAutocompleteController
{
    public function executar(string $termo): array
    {
        $repository = new CartaRepositoryPDO();
        $service = new BuscarCartaAutocompleteService($repository);

        return $service->executar($termo);
    }
}
