<?php
require "conexao.php";

// Validação básica
$camposObrigatorios = [
    'nomeCarta', 'nomeEdicao', 'raridade',
    'condicao', 'idioma', 'tipo',
    'valorCarta', 'quantidade'
];

foreach ($camposObrigatorios as $campo) {
    if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
        die("Erro: Campo {$campo} não preenchido.");
    }
}

$nome       = $_POST['nomeCarta'];
$edicao     = $_POST['nomeEdicao'];
$raridade   = $_POST['raridade'];
$condicao   = $_POST['condicao'];
$idioma     = $_POST['idioma'];
$tipo       = $_POST['tipo'];
$foil       = ($_POST['foil'] ?? 'normal') === 'foil' ? 1 : 0;
$quantidade = (int) $_POST['quantidade'];
$valor      = $_POST['valorCarta'];



$sql = $pdo->prepare("
    INSERT INTO cartas
    (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$sql->execute([
    $nome,
    $edicao,
    $raridade,
    $condicao,
    $idioma,
    $tipo,
    $foil,
    $quantidade,
    $valor
]);

header("Location: /mtg_acervo/");
exit;
