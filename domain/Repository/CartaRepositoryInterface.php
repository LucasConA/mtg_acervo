<?php
namespace App\AcervoMtg\Domain\Repository;

use App\AcervoMtg\Domain\Entity\Carta;

// Interface que define os métodos de acesso e persistência de dados relacionados à Carta */


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
    int $idioma,
    int $tipo,
    bool $foil
): bool;
    public function buscarNomesPorTermo(string $termo): array;
    public function buscarComFiltros(array $filtros): array;

}

