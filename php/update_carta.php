<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'conexao.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID inválido");
}
// Recebe os dados
$nome        = $_POST['nomeCarta'] ?? '';
$id_edicao   = $_POST['nomeEdicao'] ?? null;
$id_raridade = $_POST['raridade'] ?? null;
$id_condicao = $_POST['condicao'] ?? null;
$id_idioma   = $_POST['idioma'] ?? null;
$id_tipo     = $_POST['tipo'] ?? null;
$foil        = ($_POST['foil'] === 'foil') ? 1 : 0;
$valor       = $_POST['valorCarta'] ?? 0;

// update no banco
$sql = "
    UPDATE cartas SET
        nome = ?,
        id_edicao = ?,
        id_raridade = ?,
        id_condicao = ?,
        id_idioma = ?,
        id_tipo = ?,
        foil = ?,
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
    $valor,
    $id
]);

// Redireciona para a coleção
header("Location: /mtg_acervo/colecao.php");
exit;
