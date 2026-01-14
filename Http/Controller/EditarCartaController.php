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
        $carta = $repository->buscarPorIdComRelacionamentos($id);

        return [
            'id' => (int) $carta['id'],
            'nome' => $carta['nome'],

            'id_edicao'   => (int) $carta['id_edicao'],
            'edicao_nome' => $carta['edicao_nome'],

            'id_raridade'   => (int) $carta['id_raridade'],
            'raridade_nome' => $carta['raridade_nome'],

            'id_condicao'   => (int) $carta['id_condicao'],
            'condicao_nome' => $carta['condicao_nome'],

            'id_idioma'   => (int) $carta['id_idioma'],
            'idioma_nome' => $carta['idioma_nome'],

            'id_tipo'   => (int) $carta['id_tipo'],
            'tipo_nome' => $carta['tipo_nome'],

            'foil'       => (bool) $carta['foil'],
            'quantidade' => (int) $carta['quantidade'],
            'valor'      => (float) $carta['valor'],
        ];
    }
}


?>