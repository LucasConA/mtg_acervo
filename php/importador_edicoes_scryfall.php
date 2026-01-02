<?php
require 'conexao.php';

$url = 'https://api.scryfall.com/sets';
$json = file_get_contents($url);

if (!$json) {
    die('Erro ao acessar a API da Scryfall');
}

$data = json_decode($json, true);

$stmt = $pdo->prepare("
    INSERT INTO edicoes (codigo, nome, tipo, data_lancamento)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        nome = VALUES(nome),
        tipo = VALUES(tipo),
        data_lancamento = VALUES(data_lancamento)
");

$contador = 0;

foreach ($data['data'] as $set) {
    $stmt->execute([
        strtoupper($set['code']),
        $set['name'],
        $set['set_type'],
        $set['released_at']
    ]);
    $contador++;
}

echo "$contador edições importadas/atualizadas com sucesso!";
