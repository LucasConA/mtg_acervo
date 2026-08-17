<?php

namespace App\AcervoMtg\Http\Controller;

use App\AcervoMtg\Application\Service\LigaSeguraScraperService;
use App\AcervoMtg\Infrastructure\Repository\CartaRepositoryPDO;
use App\AcervoMtg\Infrastructure\Database\PDOConnection;
use Exception;

class AtualizarValoresController
{
    public function executar(array $requestData): void
    {
        header('Content-Type: application/json');

        // Check auth
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
            return;
        }

        $acao = $requestData['acao'] ?? '';

        try {
            if ($acao === 'preview') {
                $this->handlePreview($requestData);
            } elseif ($acao === 'confirmar') {
                $this->handleConfirmar($requestData);
            } else {
                echo json_encode(['success' => false, 'error' => 'Ação inválida']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    private function handlePreview(array $data): void
    {
        $cardIds = $data['ids'] ?? [];
        if (empty($cardIds)) {
            echo json_encode(['success' => false, 'error' => 'Nenhuma carta selecionada']);
            return;
        }

        $lojas = [
            'www.epicgame.com.br' => 'Epic Game',
            'www.bazardebagda.com.br' => 'Bazar de Bagdá',
            'www.meruru.com.br' => 'Meruru Store',
            'www.ugcardshop.com.br' => 'UG Cardshop'
        ];

        $repository = new CartaRepositoryPDO();
        $scraper = new LigaSeguraScraperService();

        $updates = [];
        $unmatched = [];

        foreach ($cardIds as $id) {
            try {
                $cardData = $repository->buscarPorIdComRelacionamentos((int)$id);
                
                $nome = $cardData['nome'];
                $edicao = $cardData['edicao_nome'];
                $condicao = $cardData['condicao_nome'];
                $condCode = $this->extractConditionCode($condicao);

                $foil = (bool)$cardData['foil'];
                $precoAtual = (float)$cardData['valor'];

                $resultadoScraper = null;
                $lojaEncontrada = '';

                // Try each store sequentially. Stop as soon as a price is found.
                foreach ($lojas as $domain => $lojaNome) {
                    // Rate limiting delay (1 second) as requested
                    usleep(1000000);

                    $res = $scraper->obterPreco($domain, $nome, $edicao, $condCode, $foil);
                    if ($res !== null) {
                        $resultadoScraper = $res;
                        $lojaEncontrada = $lojaNome;
                        break;
                    }
                }

                if ($resultadoScraper !== null) {
                    $updates[] = [
                        'id' => $id,
                        'nome' => $nome,
                        'edicao' => $edicao,
                        'condicao_original' => $condCode,
                        'condicao_encontrada' => $resultadoScraper['condicao'],
                        'loja_encontrada' => $lojaEncontrada,
                        'foil' => $foil ? 'Sim' : 'Não',
                        'preco_atual' => $precoAtual,
                        'preco_novo' => $resultadoScraper['preco']
                    ];
                } else {
                    $unmatched[] = [
                        'id' => $id,
                        'nome' => $nome,
                        'edicao' => $edicao,
                        'condicao' => $condCode,
                        'foil' => $foil ? 'Sim' : 'Não',
                        'preco_atual' => $precoAtual
                    ];
                }
            } catch (Exception $e) {
                // If single card fails, treat as unmatched
                $unmatched[] = [
                    'id' => $id,
                    'nome' => 'Erro ao carregar card #' . $id,
                    'edicao' => '',
                    'condicao' => '',
                    'foil' => 'Não',
                    'preco_atual' => 0.0,
                    'error' => $e->getMessage()
                ];
            }
        }

        echo json_encode([
            'success' => true,
            'updates' => $updates,
            'unmatched' => $unmatched
        ]);
    }

    private function handleConfirmar(array $data): void
    {
        $updates = $data['updates'] ?? [];
        if (empty($updates)) {
            echo json_encode(['success' => false, 'error' => 'Nenhuma alteração enviada']);
            return;
        }

        $pdo = PDOConnection::get();
        $pdo->beginTransaction();

        try {
            $sql = "UPDATE cartas SET valor = :valor WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            foreach ($updates as $update) {
                $id = (int)($update['id'] ?? 0);
                $valor = (float)($update['valor'] ?? 0.0);

                if ($id > 0) {
                    $stmt->execute([
                        'valor' => $valor,
                        'id' => $id
                    ]);
                }
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'error' => 'Falha ao atualizar banco de dados: ' . $e->getMessage()]);
        }
    }

    private function extractConditionCode(string $name): string
    {
        // Extract content inside parenthesis, e.g. "Praticamente Nova (NM)" -> "NM"
        if (preg_match('/\(([^)]+)\)/', $name, $matches)) {
            return trim($matches[1]);
        }
        return trim($name);
    }
}
