<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;
use App\AcervoMtg\Domain\Exception\CartaNaoEncontradaException;
use App\AcervoMtg\Domain\ValueObject\Quantidade;
use App\AcervoMtg\Domain\ValueObject\Dinheiro;
use App\AcervoMtg\Domain\ValueObject\Idioma;
use App\AcervoMtg\Domain\ValueObject\Tipo;
use App\AcervoMtg\Domain\ValueObject\Raridade;
use App\AcervoMtg\Domain\ValueObject\Condicao;
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

            if (!$carta) {
                throw new CartaNaoEncontradaException($id);
            }

            if (isset($dados['nome'])) {
                $carta->nome = $dados['nome'];
            }

            if (isset($dados['edicao'])) {
                $carta->edicao = $dados['edicao'];
            }

            if (isset($dados['raridade'])) {
                $carta->raridade = new Raridade($dados['raridade']);
            }

            if (isset($dados['condicao'])) {
                $carta->condicao = new Condicao($dados['condicao']);
            }

            if (isset($dados['idioma'])) {
                $carta->idioma = new Idioma($dados['idioma']);
            }

            if (isset($dados['tipo'])) {
                $carta->tipo = new Tipo($dados['tipo']);
            }

            if (isset($dados['foil'])) {
                $carta->foil = (bool) $dados['foil'];
            }

            if (isset($dados['quantidade'])) {
                $carta->quantidade = new Quantidade($dados['quantidade']);
            }

            if (isset($dados['valor'])) {
                $carta->valor = new Dinheiro($dados['valor']);
            }

            $this->repository->atualizar($carta);

            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
