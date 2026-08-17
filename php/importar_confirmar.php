<?php
session_start();
require_once __DIR__ . '/../config.php';
if (isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === 0) {
    header("Location: " . BASE_URL . "/aviso.php");
    exit;
}

require 'conexao.php';

if (empty($_POST['cartas']) || !is_array($_POST['cartas'])) {
    die("Dados inválidos.");
}

$pdo->beginTransaction();

$inseridas  = 0;
$duplicadas = 0;

try {

    $stmtCheck = $pdo->prepare("
        SELECT id FROM cartas
        WHERE nome = ?
          AND id_edicao = ?
          AND id_raridade = ?
          AND id_condicao = ?
          AND id_idioma = ?
          AND id_tipo = ?
          AND foil = ?
    ");

    $stmtInsert = $pdo->prepare("
        INSERT INTO cartas
        (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    foreach ($_POST['cartas'] as $c) {

        $nome       = trim($c['nome'] ?? '');
        $idEdicao   = (int)($c['edicao'] ?? 0);
        $idRaridade = (int)($c['raridade'] ?? 0);
        $idCondicao = (int)($c['condicao'] ?? 0);
        $idIdioma   = (int)($c['idioma'] ?? 0);
        $idTipo     = (int)($c['tipo'] ?? 0);
        $foil       = (int)($c['foil'] ?? 0);
        $quantidade = max(1, (int)($c['quantidade'] ?? 1));
        $valor      = (float)($c['valor'] ?? 0);

        $stmtCheck->execute([
            $nome,
            $idEdicao,
            $idRaridade,
            $idCondicao,
            $idIdioma,
            $idTipo,
            $foil
        ]);

        if ($stmtCheck->fetchColumn()) {
            $duplicadas++;
            continue;
        }

        $stmtInsert->execute([
            $nome,
            $idEdicao,
            $idRaridade,
            $idCondicao,
            $idIdioma,
            $idTipo,
            $foil,
            $quantidade,
            $valor
        ]);

        $inseridas++;
    }

    $pdo->commit();

} catch (Throwable $e) {
    $pdo->rollBack();
    die("Erro na importação: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Importação Finalizada</title>
    <link rel="stylesheet" href="../_css/estilo.css">
</head>
<body>

<div id="interface">
<h1>Importação Concluída</h1>

<div class="mensagem sucesso">
    Inseridas: <?= $inseridas ?>
</div>

<div class="mensagem erro">
    Duplicadas ignoradas: <?= $duplicadas ?>
</div>

<a href="../colecao.php" class="botao">Ir para Coleção</a>
</div>

</body>
</html>
