<?php
header('Content-Type: application/json; charset=utf-8');

$nome = trim($_GET['nome'] ?? '');

if ($nome === '') {
    echo json_encode(['nome' => '']);
    exit;
}

/**
 * ===============================
 * CONFIGURAÇÕES
 * ===============================
 */
$cacheDir  = __DIR__ . '/cache';
$cacheKey  = md5($nome);
$cacheFile = "$cacheDir/ptbr_$cacheKey.json";
$cacheTTL  = 86400; // 24 horas

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

/**
 * ===============================
 * CACHE
 * ===============================
 */
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTTL) {
    echo file_get_contents($cacheFile);
    exit;
}

/**
 * ===============================
 * FUNÇÃO CURL
 * ===============================
 */
function curlJson(string $url): ?array
{
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
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false || $httpCode !== 200) {
        return null;
    }

    return json_decode($response, true);
}

/**
 * ===============================
 * BUSCA CARTA
 * ===============================
 */
$searchUrl = 'https://api.scryfall.com/cards/search?q=' .
    urlencode('!"' . $nome . '"');

$data = curlJson($searchUrl);

$nomePT = $nome;

if (!empty($data['data'][0]['prints_search_uri'])) {

    $printsUrl = $data['data'][0]['prints_search_uri'];
    $prints    = curlJson($printsUrl);

    foreach ($prints['data'] ?? [] as $print) {
        if (($print['lang'] ?? '') === 'pt') {
            $nomePT = $print['printed_name'] ?? $nome;
            break;
        }
    }
}

/**
 * ===============================
 * OUTPUT + CACHE
 * ===============================
 */
$resultado = json_encode(['nome' => $nomePT]);

file_put_contents($cacheFile, $resultado);

echo $resultado;
