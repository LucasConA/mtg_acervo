<?php
namespace App\AcervoMtg\Domain\Repository;

use App\AcervoMtg\Domain\Entity\Carta;

interface CartaRepositoryInterface
{
    public function buscarPorId(int $id): Carta;
    public function salvar(Carta $carta): void;
    public function atualizar(Carta $carta): void;
    public function excluir(int $id): void;
    public function listar(?string $ordem = null): array;
}
