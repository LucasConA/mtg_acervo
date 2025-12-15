<?php

$pdo = new PDO("mysql:host=localhost;dbname=acervo", "root", "");

$stmt = $pdo->prepare("
    INSERT INTO cartas 
    (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, valor)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $_POST['nomeCarta'],
    $_POST['nomeEdicao'],
    $_POST['raridade'],
    $_POST['condicao'],
    $_POST['idioma'],
    $_POST['tipo'],
    $_POST['foil'] === "foil" ? 1 : 0,
    $_POST['valorCarta']
]);

echo "Carta adicionada com sucesso!";
