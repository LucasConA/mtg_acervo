<?php

/* recebe o id, busca a carta e devolve os dados prontos para a view */

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;
use PDO;

class EditarCartaController
{
    public function executar(array $query): array
    {
        $id = filter_var($query['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $pdo = PDOConnection::get();
        $repository = new CartaRepositoryPDO();

        $carta = $repository->buscarPorIdComRelacionamentos($id);

        return [
            'carta' => [
                'id'         => (int)$carta['id'],
                'nome'       => $carta['nome'],
                'id_edicao'  => (int)$carta['id_edicao'],
                'id_raridade'=> (int)$carta['id_raridade'],
                'id_condicao'=> (int)$carta['id_condicao'],
                'id_idioma'  => (int)$carta['id_idioma'],
                'id_tipo'    => (int)$carta['id_tipo'],
                'foil'       => (bool)$carta['foil'],
                'quantidade' => (int)$carta['quantidade'],
                'valor'      => (float)$carta['valor'],
            ],

            // LISTAS (sem novas funções)
            'edicoes' => $pdo->query("
                SELECT id, COALESCE(nome_pt, nome_en) AS nome
                FROM edicoes
                ORDER BY nome
            ")->fetchAll(PDO::FETCH_ASSOC),

            'raridades' => $pdo->query("
                SELECT id, nome FROM raridades ORDER BY nome
            ")->fetchAll(PDO::FETCH_ASSOC),

            'condicoes' => $pdo->query("
                SELECT id, nome FROM condicao ORDER BY nome
            ")->fetchAll(PDO::FETCH_ASSOC),

            'idiomas' => $pdo->query("
                SELECT id, nome FROM idiomas ORDER BY nome
            ")->fetchAll(PDO::FETCH_ASSOC),

            'tipos' => $pdo->query("
                SELECT id, nome FROM tipos ORDER BY nome
            ")->fetchAll(PDO::FETCH_ASSOC),
        ];
    }
}
