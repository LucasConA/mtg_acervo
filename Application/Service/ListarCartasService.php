<?php

namespace App\AcervoMtg\Application\Service;

use App\AcervoMtg\Domain\Repository\CartaRepositoryInterface;

class ListarCartasService
{
    public function __construct(
        private CartaRepositoryInterface $repository
    ) {}

    public function executar(?string $ordem = null): array
    {
        $cartas = $this->repository->listar($ordem);

        $resultado = [];
        $total = 0.0;

        foreach ($cartas as $carta) {

            $valor = (float) ($carta['valor'] ?? 0);
            $quantidade = (int) ($carta['quantidade'] ?? 0);

            $subtotal = $valor * $quantidade;
            $total += $subtotal;

            $resultado[] = [
                'id'         => (int) $carta['id'],
                'nome'       => $carta['nome'],
                'edicao'     => $carta['edicao'],     
                'raridade'   => $carta['raridade'],
                'condicao'   => $carta['condicao'],
                'idioma'     => $carta['idioma'],
                'tipo'       => $carta['tipo'],
                'foil'       => (bool) $carta['foil'],
                'quantidade' => $quantidade,
                'valor'      => $valor,
                'subtotal'   => $subtotal,
            ];
        }

        return [
            'cartas' => $resultado,
            'total'  => $total
        ];
    }
}
