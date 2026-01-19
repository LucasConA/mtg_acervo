<?php

header('Content-Type: application/json; charset=utf-8');

define('CACHE_DIR', __DIR__ . '/../cache/autocomplete/');
define('CACHE_TTL', 86400); // 24h

if (!is_dir(CACHE_DIR)) {
    mkdir(CACHE_DIR, 0777, true);
}

/* =======================
 * UTILIDADES
 * ======================= */

function responder(array $data): void
{
    echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

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

    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($res === false || $code !== 200) {
        return null;
    }

    return json_decode($res, true);
}

/* =======================
 * INPUT
 * ======================= */

$q = trim($_GET['q'] ?? '');

if (mb_strlen($q) < 2) {
    responder([]);
}

$qKey = preg_replace('/[^a-z0-9_]/i', '_', strtolower($q));
$cacheFile = CACHE_DIR . "autocomplete_$qKey.json";

/* =======================
 * CACHE
 * ======================= */

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < CACHE_TTL) {
    responder(json_decode(file_get_contents($cacheFile), true));
}

/* =======================
 * AUTOCOMPLETE (EN)
 * ======================= */

$auto = curlJson(
    'https://api.scryfall.com/cards/autocomplete?q=' . urlencode($q)
);

$nomesEn = $auto['data'] ?? [];

$resultado = [];

foreach ($nomesEn as $nomeEn) {

    $nomePt = null;

    /* =======================
     * RESOLVE PT VIA PRINTS
     * ======================= */

    $search = curlJson(
        'https://api.scryfall.com/cards/search?q=' .
        urlencode('!"' . $nomeEn . '"')
    );

    if (!empty($search['data'][0]['prints_search_uri'])) {

        $prints = curlJson($search['data'][0]['prints_search_uri']);

        foreach ($prints['data'] ?? [] as $print) {
            if (($print['lang'] ?? '') === 'pt') {
                $nomePt = $print['printed_name'] ?? null;
                break;
            }
        }
    }

    $resultado[] = [
        'en' => $nomeEn,
        'pt' => $nomePt
    ];
}

/* =======================
 * CACHE + OUTPUT
 * ======================= */

file_put_contents(
    $cacheFile,
    json_encode($resultado, JSON_UNESCAPED_UNICODE)
);

responder($resultado);
