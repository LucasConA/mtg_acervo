<?php
namespace App\AcervoMtg\Domain\Repository;

use App\AcervoMtg\Domain\Entity\Carta;
use App\AcervoMtg\Domain\ValueObject\Idioma;
use App\AcervoMtg\Domain\ValueObject\Tipo;

interface CartaRepositoryInterface
{
    public function buscarPorId(int $id): Carta;

    public function buscarDadosEdicao(int $id): array;

    public function salvar(Carta $carta): void;

    public function atualizar(Carta $carta): void;

    public function excluir(int $id): void;

    public function listar(?string $ordem = null): array;

    public function existeDuplicada(
        string $nome,
        int $edicao,
        Idioma $idioma,
        Tipo $tipo,
        bool $foil
    ): bool;

    public function buscarNomesPorTermo(string $termo): array;

    public function buscarComFiltros(array $filtros): array;
}
