<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use PDO;

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

            $carta->nome       = $dados['nome'];
            $carta->edicao     = $dados['edicao'];
            $carta->raridade   = $dados['raridade'];
            $carta->condicao   = $dados['condicao'];
            $carta->idioma     = $dados['idioma'];
            $carta->tipo       = $dados['tipo'];
            $carta->foil       = (bool) $dados['foil'];
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
