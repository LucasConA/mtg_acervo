<?php

$termo = trim($_GET['q'] ?? '');

if (strlen($termo) < 2) {
    echo json_encode([]);
    exit;
}

$url = 'https://api.scryfall.com/cards/autocomplete?q=' . urlencode($termo);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

$resultado = $data['data'] ?? [];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resultado);
