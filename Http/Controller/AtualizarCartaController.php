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
            'nome'       => trim($post['nomeCarta'] ?? ''),
            'edicao'     => (int) ($post['id_edicao'] ?? 0),
            'raridade'   => (int) ($post['id_raridade'] ?? 0),
            'condicao'   => (int) ($post['id_condicao'] ?? 0),
            'idioma'     => (int) ($post['id_idioma'] ?? 0),
            'tipo'       => (int) ($post['id_tipo'] ?? 0),
            'foil'       => (bool) ($post['foil'] ?? false),
            'quantidade' => (int) ($post['quantidade'] ?? 1),
            'valor' => (float) str_replace(',', '.', $post['valorCarta'] ?? 0),
        ];

        $service = new AtualizarCartaService(
            new CartaRepositoryPDO(),
            PDOConnection::get()
        );

        $service->executar($id, $dados);

        header('Location: /mtg_acervo/colecao.php?sucesso=update');
        exit;
    }
}
