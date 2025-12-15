<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'conexao.php';

// Valida o ID
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID inválido");
}

// DELETE
$sql = "DELETE FROM cartas WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Volta para a coleção
header("Location: /mtg_acervo/colecao.php");
exit;
