<?php
require 'conexao.php';

if (!isset($_POST['cartas']) || !is_array($_POST['cartas'])) {
    die("Dados inválidos.");
}

$pdo->beginTransaction();

$inseridas = 0;
$duplicadas = 0;

try {

    $check = $pdo->prepare("
        SELECT id FROM cartas
        WHERE nome = ?
          AND id_edicao = ?
          AND id_idioma = ?
          AND id_tipo = ?
          AND foil = ?
    ");

    $insert = $pdo->prepare("
        INSERT INTO cartas
        (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    foreach ($_POST['cartas'] as $c) {

        $check->execute([
            $c['nome'],
            $c['edicao'],
            $c['idioma'],
            $c['tipo'],
            $c['foil']
        ]);

        if ($check->fetch()) {
            $duplicadas++;
            continue;
        }

        $insert->execute([
            $c['nome'],
            $c['edicao'],
            $c['raridade'],
            $c['condicao'],
            $c['idioma'],
            $c['tipo'],
            $c['foil'],
            $c['quantidade'],
            $c['valor']
        ]);

        $inseridas++;
    }

    $pdo->commit();

} catch (Exception $e) {
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
