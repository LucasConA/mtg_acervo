<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class BuscarCartaService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(int $id): array
    {
        $carta = $this->repository->buscarPorId($id);

        return [
            'id'          => $carta->id,
            'nome'        => $carta->nome,
            'id_edicao'   => $carta->edicao,
            'id_raridade' => $carta->raridade,
            'id_condicao' => $carta->condicao,
            'id_idioma'   => $carta->idioma,
            'id_tipo'     => $carta->tipo,
            'foil'        => $carta->foil,
            'quantidade'  => $carta->quantidade,
            'valor'       => $carta->valor,
        ];
    }
}

?>