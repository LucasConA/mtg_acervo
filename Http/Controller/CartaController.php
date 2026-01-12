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

        $total = array_reduce(
            $cartas,
            fn (float $carry, $carta) =>
                $carry + ($carta->valor * $carta->quantidade),
            0.0
        );

        return [
            'cartas' => array_map(fn ($carta) => [
                'id'         => $carta->id,
                'carta'      => $carta->nome,
                'edicao'     => $carta->edicao,
                'raridade'   => $carta->raridade,
                'condicao'   => $carta->condicao,
                'idioma'     => $carta->idioma,
                'tipo'       => $carta->tipo,
                'foil'       => $carta->foil,
                'quantidade' => $carta->quantidade,
                'valor'      => $carta->valor,
            ], $cartas),
            'total' => $total
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

}
