<?php
$pdo = new PDO("mysql:host=localhost;dbname=acervo", "root", "");
// Consulta com JOINs para pegar os nomes das Foreign keys
$sql = $pdo->query("
    SELECT 
        cartas.id,
        cartas.nome,
        edicoes.nome AS edicao,
        raridades.nome AS raridade,
        condicao.nome AS condicao,
        idiomas.nome AS idioma,
        tipos.nome AS tipo,
        cartas.foil,
        cartas.valor
    FROM cartas
    JOIN edicoes ON cartas.id_edicao = edicoes.id
    JOIN raridades ON cartas.id_condicao = raridades.id
    JOIN condicao ON cartas.id_condicao = condicao.id
    JOIN idiomas ON cartas.id_idioma = idiomas.id
    JOIN tipos ON cartas.id_tipo = tipos.id
    ORDER BY cartas.nome ASC
");

$cartas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Acervo MTG - Todas as Cartas</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>
<body>

<h1>Lista de Cartas Cadastradas</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Edição</th>
            <th>Raridade</th>
            <th>Condição</th>
            <th>Idioma</th>
            <th>Tipo</th>
            <th>Foil</th>
            <th>Valor (R$)</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($cartas as $c): ?>
        <tr>
            <td><?= $c['nome'] ?></td>
            <td><?= $c['edicao'] ?></td>
            <td><?= $c['raridade'] ?></td>
            <td><?= $c['condicao'] ?></td>
            <td><?= $c['idioma'] ?></td>
            <td><?= $c['tipo'] ?></td>
            <td><?= $c['foil'] ?></td>
            <td><?= number_format($c['valor'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
