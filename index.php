<?php
require 'php/buscar_cartas.php';

$filtros = [
    'nome' => $_GET['busca_nome'] ?? null,
    'edicao' => $_GET['busca_edicao'] ?? null,
    'raridade' => $_GET['busca_raridade'] ?? null,
    'tipo' => $_GET['busca_tipo'] ?? null,
];

$cartas = [];
$totalFiltrado = 0;

if (array_filter($filtros)) {
    [$cartas, $totalFiltrado] = buscarCartas($filtros);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acervo MTG</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header id="cabecalho">
    <h1>Acervo MTG</h1>
    <nav>
        <a href="/mtg_acervo/colecao.php" class="botao">Minha Coleção</a>
    </nav>
</header>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="mensagem sucesso">Carta adicionada com sucesso!</div>
<?php endif; ?>

<h2>Buscar cartas</h2>

<form method="get" action="#resultado">
    <label>Nome:</label>
    <input type="text" name="busca_nome" value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>">

    <label>Edição:</label>
    <select name="busca_edicao">
        <option value="">Todas</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select>

    <label>Raridade:</label>
    <select name="busca_raridade">
        <option value="">Todas</option>
        <?php include 'php/carregar_raridades.php'; ?>
    </select>

    <label>Tipo:</label>
    <select name="busca_tipo">
        <option value="">Todos</option>
        <?php include 'php/carregar_tipos.php'; ?>
    </select>

    <button type="submit" class="botao">Buscar</button>
</form>

<section id="resultado">
<?php if (!empty($cartas)): ?>
<table>
    <tr>
        <th>Nome</th>
        <th>Edição</th>
        <th>Raridade</th>
        <th>Condição</th>
        <th>Idioma</th>
        <th>Tipo</th>
        <th>Foil</th>
        <th>Valor</th>
    </tr>

    <?php foreach ($cartas as $c): ?>
    <tr>
        <td><?= htmlspecialchars($c['nome']) ?></td>
        <td><?= htmlspecialchars($c['edicao']) ?></td>
        <td><?= htmlspecialchars($c['raridade']) ?></td>
        <td><?= htmlspecialchars($c['condicao']) ?></td>
        <td><?= htmlspecialchars($c['idioma']) ?></td>
        <td><?= htmlspecialchars($c['tipo']) ?></td>
        <td><?= $c['foil'] ? 'Foil' : 'Normal' ?></td>
        <td>R$ <?= number_format($c['valor'], 2, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>

    <tfoot>
        <tr>
            <td colspan="7"><strong>Total</strong></td>
            <td><strong>R$ <?= number_format($totalFiltrado, 2, ',', '.') ?></strong></td>
        </tr>
    </tfoot>
</table>
<?php endif; ?>
</section>

</div>

<script src="_js/autocomplete.js" defer></script>
<script src="_js/buscar_ptbr.js" defer></script>
</body>
</html>
