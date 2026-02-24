<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use PDO;

// Atualiza uma carta existente aplicando novos dados e salvando as alterações


class AtualizarCartaService
{
    public function __construct(
        private CartaRepositoryInterface $repository,
        private PDO $pdo
    ) {}

    public function executar(int $id, array $dados): void
    {
        $this->pdo->beginTransaction();

        try {
            $carta = $this->repository->buscarPorId($id);

            $carta->nome       = $dados['nome']       ?: $carta->nome;
            $carta->edicao     = $dados['edicao']     ?: $carta->edicao;
            $carta->raridade   = $dados['raridade']   ?: $carta->raridade;
            $carta->condicao   = $dados['condicao']   ?: $carta->condicao;
            $carta->idioma     = $dados['idioma']     ?: $carta->idioma;
            $carta->tipo       = $dados['tipo']       ?: $carta->tipo;
            $carta->foil       = $dados['foil'];
            $carta->quantidade = $dados['quantidade'];
            $carta->valor      = $dados['valor'];

            $this->repository->atualizar($carta);

            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
