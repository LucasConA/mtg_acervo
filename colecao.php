<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\CartaController;

$controller = new CartaController();

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
        <a href="/src/AcervoMtg/index.php" class="botao">Adicionar Carta</a>
    </nav>
</header>

<main>

<?php if (empty($cartas)): ?>
    <h2>Nenhuma carta cadastrada ainda.</h2>
<?php else: ?>

<form method="get">
    <label class="campoTitulo">Ordenar por:</label>

    <select name="ordem" onchange="this.form.submit()">
        <option value="">Padrão</option>
        <option value="valor_asc" <?= $ordem === 'valor_asc' ? 'selected' : '' ?>>Menor valor</option>
        <option value="valor_desc" <?= $ordem === 'valor_desc' ? 'selected' : '' ?>>Maior valor</option>
        <option value="nome_asc" <?= $ordem === 'nome_asc' ? 'selected' : '' ?>>Nome (A–Z)</option>
        <option value="nome_desc" <?= $ordem === 'nome_desc' ? 'selected' : '' ?>>Nome (Z–A)</option>
    </select>
</form>

<div class="tabela-container">
<table id="lista_cartas" border="1" cellpadding="8">
    <thead>
        <tr>
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
                <a href="/src/AcervoMtg/editar_carta.php?id=<?= (int)$carta['id'] ?>" class="botao">
                    Editar
                </a>

                <form action="/src/AcervoMtg/excluir_carta.php" 
                        method="post"
                        class="form-excluir"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta carta?');">

                        <input type="hidden" name="id" value="<?= $carta['id'] ?>">
                        <button type="submit" class="botao botao-excluir">Excluir</button>
                </form>

                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="8" style="text-align:right; font-weight:bold; color:#d4af37;">
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

</main>
</div>
</body>
</html>
