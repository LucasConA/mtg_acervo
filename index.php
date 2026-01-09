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
    <title>Acervo MTG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header id="cabecalho">
    <h1>Acervo MTG</h1>

    <nav id="menu">
        <ul>
            <li>
                <a href="/mtg_acervo/colecao.php" class="botao">
                    Minha Coleção
                </a>
            </li>
        </ul>
    </nav>
</header>

<?php include 'views/adicionar_form.php'; ?>
<?php include 'views/importar_form.php'; ?>
<?php include 'views/buscar_form.php'; ?>

<footer id="rodape"></footer>

</div>

<script src="_js/autocomplete.js"></script>
<script src="_js/buscar_ptbr.js"></script>
</body>
</html>
