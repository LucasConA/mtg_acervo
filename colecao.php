<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/auth.php';



use App\AcervoMtg\Http\Controller\CartaController;

$controller = new CartaController();

/**
 * POST — Excluir carta
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
    try {
        $controller->excluir($_POST);
        header('Location: colecao.php');
        exit;
    } catch (Throwable $e) {
        die($e->getMessage());
    }
}

/**
 * GET — Listar carta
 */

try {
    $ordem = $_GET['ordem'] ?? null;
    $resultado = $controller->listar(['ordem' => $ordem]);

    $cartas = $resultado['cartas'];
    $totalColecao = $resultado['total'];

} catch (Throwable $e) {
    die($e->getMessage());
}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Coleção - Acervo MTG</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header id="cabecalho">
    <h1>Minha Coleção</h1>

     <nav id="menu">
        <ul>
            <li>Olá, <?= $_SESSION['usuario_nome'] ?></li>
            <li>
                <a href="<?= BASE_URL ?>/index.php" class="botao">
                Adicionar Carta
                </a>
            </li>
        </ul>

        <ul>

            <li><a href="<?= BASE_URL ?>/logout.php" class="botao">Sair</a></li>
        </ul>

</header>

<main>

<?php if (empty($cartas)): ?>
    <h2>Nenhuma carta cadastrada ainda.</h2>
<?php else: ?>

<div style="position: sticky; top: 80px; background-color: #202020; z-index: 100; padding: 15px 0; border-bottom: 2px solid #d4af37; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <form method="get" style="margin: 0; display: inline-block;">
            <label class="campoTitulo">Ordenar por:</label>

            <select name="ordem" onchange="this.form.submit()">
                <option value="">Padrão</option>
                <option value="valor_asc" <?= $ordem === 'valor_asc' ? 'selected' : '' ?>>Menor valor</option>
                <option value="valor_desc" <?= $ordem === 'valor_desc' ? 'selected' : '' ?>>Maior valor</option>
                <option value="nome_asc" <?= $ordem === 'nome_asc' ? 'selected' : '' ?>>Nome (A–Z)</option>
                <option value="nome_desc" <?= $ordem === 'nome_desc' ? 'selected' : '' ?>>Nome (Z–A)</option>
            </select>
        </form>

        <div style="position: relative; display: flex; align-items: center; gap: 5px;">
            <label class="campoTitulo" style="margin: 0;">Buscar na Coleção:</label>
            <input type="text" id="buscar-carta-colecao" placeholder="Nome da carta..." autocomplete="off" style="padding: 6px; border-radius: 4px; border: 1px solid #444; background: #2a2a2a; color: #fff; width: 220px;">
            <button type="button" id="btn-limpar-busca" class="botao" style="padding: 4px 10px; display: none;">Limpar</button>
            <div id="autocomplete-colecao" style="position: absolute; left: 140px; right: 65px; top: 35px; background: #2a2a2a; border: 1px solid #444; max-height: 200px; overflow-y: auto; z-index: 1000; display: none; border-radius: 0 0 4px 4px; box-shadow: 0px 4px 6px rgba(0,0,0,0.3);"></div>
        </div>
    </div>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <button type="button" id="btn-atualizar-precos" class="botao" style="background-color: #d4af37; color: #202020; border-color: #d4af37;">
            Atualizar Preços
        </button>
    <?php endif; ?>
</div>

<div class="tabela-container">
<table id="lista_cartas" border="1" cellpadding="8">
    <thead>
        <tr>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <th style="width: 30px; text-align: center;"><input type="checkbox" id="selecionar_todas"></th>
            <?php endif; ?>
            <th>Nome</th>
            <th>Edição</th>
            <th>Raridade</th>
            <th>Condição</th>
            <th>Idioma</th>
            <th>Tipo</th>
            <th>Foil</th>
            <th>Quantidade</th>
            <th>Valor (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($cartas as $carta): ?>
        <tr>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <td style="text-align: center;">
                    <input type="checkbox" name="carta_ids[]" value="<?= $carta['id'] ?>" class="carta-checkbox">
                </td>
            <?php endif; ?>
            <td><?= htmlspecialchars($carta['nome'] ?? '') ?></td>
            <td><?= htmlspecialchars($carta['edicao']) ?></td>
            <td><?= htmlspecialchars($carta['raridade']) ?></td>
            <td><?= htmlspecialchars($carta['condicao']) ?></td>
            <td><?= htmlspecialchars($carta['idioma']) ?></td>
            <td><?= htmlspecialchars($carta['tipo']) ?></td>
            <td><?= $carta['foil'] ? 'Sim' : 'Não' ?></td>
            <td><?= (int)$carta['quantidade'] ?></td>
            <td><?= number_format((float)($carta['valor'] ?? 0), 2, ',', '.') ?></td>
            <td>
                <div class="acoes">
                <?php if (isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === 0): ?>
                    <a href="#" class="botao" style="background-color: #444; border-color: #555; color: #888; cursor: not-allowed; pointer-events: none;">
                        Editar
                    </a>
                    <button type="button" class="botao" style="background-color: #333; border-color: #444; color: #666; cursor: not-allowed;" disabled>
                        Excluir
                    </button>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/editar_carta.php?id=<?= (int)$carta['id'] ?>" class="botao">
                        Editar
                    </a>
                    <form   method="post"
                            class="form-excluir"
                            onsubmit="return confirm('Tem certeza que deseja excluir esta carta?');">
                            
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $carta['id'] ?>">
                            <button type="submit" class="botao botao-excluir">Excluir</button>
                    </form>
                <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="<?= isset($_SESSION['usuario_id']) ? '9' : '8' ?>" style="text-align:right; font-weight:bold; color:#d4af37;">
                Valor total da coleção
            </td>
            <td colspan="2" style="font-weight:bold;">
                R$ <?= number_format($totalColecao, 2, ',', '.') ?>
            </td>
        </tr>
    </tfoot>
</table>
</div>
<?php endif; ?>

<!-- Modals for Scraper -->
<div id="modal-loading-scraper" class="modal" style="display: none;">
    <div class="modal-box">
        <h2>Buscando Valores</h2>
        <p id="loading-scraper-text">Calculando preço (1 de 1)...</p>
        <div class="spinner" style="margin: 15px auto; width: 40px; height: 40px; border: 4px solid rgba(212,175,55,0.2); border-left-color: #d4af37; border-radius: 50%; animation: spin 1s linear infinite;"></div>
    </div>
</div>

<div id="modal-preview-scraper" class="modal" style="display: none;">
    <div class="modal-box" style="width: 800px; max-width: 90%; max-height: 85vh; overflow-y: auto; text-align: left;">
        <button class="fechar" onclick="document.getElementById('modal-preview-scraper').style.display='none'">×</button>
        <h2>Visualizar Alterações de Preços</h2>
        <p>Revise as alterações abaixo antes de aplicar ao seu acervo:</p>
        
        <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px; border: 1px solid #444;">
            <table style="width: 100%; border-collapse: collapse; background: #282828;">
                <thead>
                    <tr style="border-bottom: 1px solid #444; text-align: left; background: #1a1a1a;">
                        <th style="padding: 10px;">Nome</th>
                        <th style="padding: 10px;">Edição</th>
                        <th style="padding: 10px; text-align: center;">Foil</th>
                        <th style="padding: 10px; text-align: center;">Loja</th>
                        <th style="padding: 10px; text-align: center;">Orig. (Cond.)</th>
                        <th style="padding: 10px; text-align: center;">Encontrado (Cond.)</th>
                        <th style="padding: 10px; text-align: right;">Preço Atual</th>
                        <th style="padding: 10px; text-align: right;">Preço Novo</th>
                    </tr>
                </thead>
                <tbody id="preview-scraper-tbody">
                    <!-- rows generated dynamically -->
                </tbody>
            </table>
        </div>

        <div id="preview-unmatched-section" style="display: none; margin-bottom: 20px; padding: 10px; border: 1px solid #4a2c2c; background: #2b1c1c; border-radius: 5px;">
            <h3 style="color: #ffb3b3; margin-top: 0;">Cards Não Encontrados</h3>
            <p style="font-size: 14px; color: #ddd; margin-bottom: 8px;">Os seguintes cards não tiveram correspondência exata no estoque de nenhuma das lojas consultadas e serão ignorados:</p>
            <ul id="preview-unmatched-list" style="color: #ffb3b3; font-size: 14px; max-height: 120px; overflow-y: auto; padding-left: 20px; margin: 0;">
                <!-- unmatched items generated dynamically -->
            </ul>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btn-cancelar-scraper" class="botao" onclick="document.getElementById('modal-preview-scraper').style.display='none'">Cancelar</button>
            <button id="btn-confirmar-scraper" class="botao" style="background-color: #d4af37; color: #202020; border-color: #d4af37;">Confirmar e Aplicar</button>
        </div>
    </div>
</div>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= BASE_URL ?>/_js/atualizar_precos.js?v=<?= filemtime(__DIR__ . '/_js/atualizar_precos.js') ?>" defer></script>

</main>
</div>
</body>
</html>
