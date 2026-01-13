<?php

/* recebe o id, bvusca a carta e devolve os dados prontos para a view */

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;

class EditarCartaController
{
    public function executar(array $query): array
    {
        $id = filter_var($query['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $repository = new CartaRepositoryPDO();
        $carta = $repository->buscarPorId($id);

        return [
            'id'         => $carta->id,
            'nome'       => $carta->nome,
            'edicao'     => $carta->edicao,
            'raridade'   => $carta->raridade,
            'condicao'   => $carta->condicao,
            'idioma'     => $carta->idioma,
            'tipo'       => $carta->tipo,
            'foil'       => $carta->foil,
            'quantidade' => $carta->quantidade,
            'valor'      => $carta->valor,
        ];
    }
}
?>