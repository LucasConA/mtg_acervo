<?php
declare(strict_types=1);

require __DIR__ . '/conexao.php';

/**
 * Tabelas permitidas para carregamento genérico
 */
$permitidas = [
    'condicao',
    'idiomas',
    'tipos',
    'raridades'
];

$tabela = $_GET['tabela'] ?? '';

if (!in_array($tabela, $permitidas, true)) {
    exit;
}

$sql = "SELECT id, nome FROM {$tabela} ORDER BY id";
$stmt = $pdo->query($sql);

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = (int) $linha['id'];
    $nome = htmlspecialchars($linha['nome'], ENT_QUOTES, 'UTF-8');

    echo "<option value=\"{$id}\">{$nome}</option>";
}
