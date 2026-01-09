<?php
declare(strict_types=1);

require __DIR__ . '/conexao.php';

/**
 * Campos obrigatórios do formulário
 */
$requiredFields = [
    'nomeCarta',
    'nomeEdicao',
    'raridade',
    'condicao',
    'idioma',
    'tipo',
    'quantidade',
    'valorCarta',
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim((string)$_POST[$field]) === '') {
        header('Location: /mtg_acervo/index.php?erro=campo');
        exit;
    }
}

/**
 * Sanitização e tipagem
 */
$nome       = trim($_POST['nomeCarta']);
$edicao     = (int) $_POST['nomeEdicao'];
$raridade   = (int) $_POST['raridade'];
$condicao   = (int) $_POST['condicao'];
$idioma     = (int) $_POST['idioma'];
$tipo       = (int) $_POST['tipo'];
$quantidade = max(1, (int) $_POST['quantidade']);
$valor      = (float) $_POST['valorCarta'];
$foil       = isset($_POST['foil']) ? (int) $_POST['foil'] : 0;

try {
    $stmt = $pdo->prepare(
        'INSERT INTO cartas
        (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES
        (:nome, :edicao, :raridade, :condicao, :idioma, :tipo, :foil, :quantidade, :valor)'
    );

    $stmt->execute([
        ':nome'       => $nome,
        ':edicao'     => $edicao,
        ':raridade'   => $raridade,
        ':condicao'   => $condicao,
        ':idioma'     => $idioma,
        ':tipo'       => $tipo,
        ':foil'       => $foil,
        ':quantidade' => $quantidade,
        ':valor'      => $valor,
    ]);

    header('Location: /mtg_acervo/index.php?sucesso=1');
    exit;

} catch (PDOException $e) {
    // em produção: logar erro
    header('Location: /mtg_acervo/index.php?erro=banco');
    exit;
}
