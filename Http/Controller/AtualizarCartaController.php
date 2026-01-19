<?php

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\AtualizarCartaService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;

class AtualizarCartaController
{
    public function executar(array $post): void
    {
        $id = filter_var($post['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $dados = [
            'nome'       => trim($post['nome'] ?? ''),
            'edicao'     => (int) ($post['edicao'] ?? 0),
            'raridade'   => (int) ($post['raridade'] ?? 0),
            'condicao'   => (int) ($post['condicao'] ?? 0),
            'idioma'     => (int) ($post['idioma'] ?? 0),
            'tipo'       => (int) ($post['tipo'] ?? 0),
            'foil'       => isset($post['foil']) && (int)$post['foil'] === 1,
            'quantidade' => (int) ($post['quantidade'] ?? 1),
            'valor'      => (float) str_replace(',', '.', $post['valor'] ?? 0),
        ];

        $service = new AtualizarCartaService(
            new CartaRepositoryPDO(),
            PDOConnection::get()
        );

        $service->executar($id, $dados);
    }
}
