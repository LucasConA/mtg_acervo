<?php
namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\DTO\CartaImportadaDTO;
use App\AcervoMtg\Application\Service\ImportarCartasService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;

class ImportacaoController
{
    public function confirmar(array $post): array
    {
        $dtos = [];

        foreach ($post['cartas'] as $c) {
            $dtos[] = new CartaImportadaDTO(
                $c['nome'],
                (int)$c['edicao'],
                (int)$c['raridade'],
                (int)$c['condicao'],
                (int)$c['idioma'],
                (int)$c['tipo'],
                (bool)$c['foil'],
                (int)$c['quantidade'],
                (float)$c['valor']
            );
        }

        $repository = new CartaRepositoryPDO();
        $service = new ImportarCartasService(
            $repository,
            PDOConnection::get()
        );

        return $service->executar($dtos);
    }
}
