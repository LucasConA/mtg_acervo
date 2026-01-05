<?php

$nome = trim($_GET['nome'] ?? '');
if ($nome === '') exit;

$url = 'https://api.scryfall.com/cards/search?q=' . urlencode('!"' . $nome . '"');

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$nomePT = $nome;

if (!empty($data['data'][0]['prints_search_uri'])) {

    $printsUrl = $data['data'][0]['prints_search_uri'];

    $ch = curl_init($printsUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5
    ]);

    $prints = json_decode(curl_exec($ch), true);
    curl_close($ch);

    foreach ($prints['data'] ?? [] as $print) {
        if (($print['lang'] ?? '') === 'pt') {
            $nomePT = $print['printed_name'] ?? $nome;
            break;
        }
    }
}

echo json_encode(['nome' => $nomePT]);
