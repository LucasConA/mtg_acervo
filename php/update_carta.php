<?php
require 'conexao.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ID inválido');
}

$nome        = trim($_POST['nomeCarta'] ?? '');
$id_edicao   = (int) ($_POST['id_edicao'] ?? 0);
$id_raridade = (int) ($_POST['id_raridade'] ?? 0);
$id_condicao = (int) ($_POST['id_condicao'] ?? 0);
$id_idioma   = (int) ($_POST['id_idioma'] ?? 0);
$id_tipo     = (int) ($_POST['id_tipo'] ?? 0);
$foil        = (int) ($_POST['foil'] ?? 0);
$quantidade  = (int) ($_POST['quantidade'] ?? 1);
$valor       = (float) ($_POST['valorCarta'] ?? 0);

$sql = "
    UPDATE cartas SET
        nome = ?,
        id_edicao = ?,
        id_raridade = ?,
        id_condicao = ?,
        id_idioma = ?,
        id_tipo = ?,
        foil = ?,
        quantidade = ?,
        valor = ?
    WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $nome,
    $id_edicao,
    $id_raridade,
    $id_condicao,
    $id_idioma,
    $id_tipo,
    $foil,
    $quantidade,
    $valor,
    $id
]);

header("Location: /mtg_acervo/colecao.php?sucesso=update");
exit;
