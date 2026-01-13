<?php

/* recebe o id, busca a carta e devolve os dados prontos para a view */

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
            'id_edicao'  => $carta->edicao,
            'id_raridade'=> $carta->raridade,
            'id_condicao'=> $carta->condicao,
            'id_idioma'  => $carta->idioma,
            'id_tipo'    => $carta->tipo,
            'foil'       => $carta->foil,
            'quantidade' => $carta->quantidade,
            'valor'      => $carta->valor,
        ];
    }
}

?>