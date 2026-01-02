<?php
require 'conexao.php';

$json = file_get_contents('https://api.scryfall.com/sets');
$data = json_decode($json, true);

$stmt = $pdo->prepare("
    INSERT INTO edicoes (codigo, nome, tipo, data_lancamento)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        nome = VALUES(nome),
        tipo = VALUES(tipo),
        data_lancamento = VALUES(data_lancamento)
");

foreach ($data['data'] as $set) {
    $stmt->execute([
        strtoupper($set['code']),
        $set['name'],
        $set['set_type'],
        $set['released_at']
    ]);
}

echo "✔ Todas as edições do MTG foram importadas com sucesso!";
