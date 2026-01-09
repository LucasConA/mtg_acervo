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
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header>
    <h1>Acervo MTG</h1>
</header>

<?php include 'views/adicionar_form.php'; ?>
<?php include 'views/importar_form.php'; ?>
<?php include 'views/buscar_form.php'; ?>

</div>

<script src="_js/autocomplete.js" defer></script>
<script src="_js/buscar_ptbr.js" defer></script>
</body>
</html>
