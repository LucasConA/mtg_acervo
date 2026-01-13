<?php

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\AtualizarCartaService;
use App\AcervoMtg\Application\Service\ExcluirCartaService;
use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;

class CartaController
{
    private CartaRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = new CartaRepositoryPDO();
    }

    /**
     * Lista cartas da coleção
     */
    public function listar(array $params = []): array
{
    $ordem = $params['ordem'] ?? null;

    $cartas = $this->repository->listar($ordem);

    $total = 0.0;
    foreach ($cartas as $carta) {
        $total += $carta['valor'] * $carta['quantidade'];
    }

    return [
        'cartas' => $cartas,
        'total'  => $total
    ];
}


    public function atualizar(array $post): void
{
        $id = filter_var($post['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $dados = [
            'nome'       => trim($post['nome'] ?? ''),
            'edicao'     => (int)($post['edicao'] ?? 0),
            'raridade'   => (int)($post['raridade'] ?? 0),
            'condicao'   => (int)($post['condicao'] ?? 0),
            'idioma'     => (int)($post['idioma'] ?? 0),
            'tipo'       => (int)($post['tipo'] ?? 0),
            'foil'       => isset($post['foil']),
            'quantidade' => (int)($post['quantidade'] ?? 0),
            'valor'      => (float)($post['valor'] ?? 0),
        ];

        $service = new AtualizarCartaService(
            $this->repository,
            PDOConnection::get()
        );

        $service->executar($id, $dados);
    }


    /**
     * Exclui uma carta
     */
    public function excluir(array $post): void
{
    $id = filter_var($post['id'] ?? null, FILTER_VALIDATE_INT);

    if (!$id) {
        throw new \InvalidArgumentException('ID inválido');
    }

    $service = new ExcluirCartaService(
        $this->repository,
        PDOConnection::get()
    );

    $service->executar($id);
}

public function buscar(int $id): array
{
    if ($id <= 0) {
        throw new \InvalidArgumentException('ID inválido');
    }

    $carta = $this->repository->buscarPorId($id);

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
