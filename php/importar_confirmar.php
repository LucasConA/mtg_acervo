<?php
session_start();
require 'conexao.php';

if (empty($_SESSION['preview_importacao'])) {
    die("Nada para importar.");
}

$dados = $_SESSION['preview_importacao'];

$insert = $pdo->prepare("
    INSERT INTO cartas
    (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
    VALUES (?,?,?,?,?,?,?,?,?)
");

foreach ($dados as $c) {
    $insert->execute([
        $c['nome'],
        $c['id_edicao'],
        $c['id_raridade'],
        $c['id_condicao'],
        $c['id_idioma'],
        $c['id_tipo'],
        $c['foil'],
        $c['quantidade'],
        $c['valor']
    ]);
}

unset($_SESSION['preview_importacao']);

echo "Importação concluída com sucesso.";
