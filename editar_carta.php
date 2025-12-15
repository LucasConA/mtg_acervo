<?php
require 'php/conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID inválido");
}

$sql = "
    SELECT *
    FROM cartas
    WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$carta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carta) {
    die("Carta não encontrada");
}
?>
