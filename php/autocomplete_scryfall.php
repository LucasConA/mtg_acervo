<?php
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');

if (strlen($q) < 2) {
    echo json_encode(['data' => []]);
    exit;
}

$url = 'https://api.scryfall.com/cards/autocomplete?q=' . urlencode($q);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: MTG-Acervo/1.0'
    ]
]);

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode(['data' => []]);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(['data' => []]);
    exit;
}

$data = json_decode($response, true);

echo json_encode([
    'data' => $data['data'] ?? []
]);
