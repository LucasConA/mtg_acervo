<?php
namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\AtualizarCartaService;
use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Infrastructure\Database\CartaRepositoryPDO;

class CartaController
{
    public function atualizar(array $post): void
    {
        $carta = new Carta(
            id: (int)$post['id'],
            nome: trim($post['nomeCarta']),
            edicao: (int)$post['id_edicao'],
            raridade: (int)$post['id_raridade'],
            condicao: (int)$post['id_condicao'],
            idioma: (int)$post['id_idioma'],
            tipo: (int)$post['id_tipo'],
            foil: (bool)$post['foil'],
            quantidade: (int)$post['quantidade'],
            valor: (float)$post['valorCarta']
        );

        $repository = new CartaRepositoryPDO();
        $service = new AtualizarCartaService($repository);

        $service->executar($carta);
    }
}
?>