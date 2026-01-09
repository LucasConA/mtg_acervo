<?php

header('Content-Type: application/json; charset=utf-8');

define('CACHE_DIR', __DIR__ . '/../cache/autocomplete/');
define('CACHE_TTL', 3600); // 1 hora

/**
 * Retorna o termo de busca validado
 */
function getQuery(): string
{
    $q = trim($_GET['q'] ?? '');
    return strlen($q) >= 2 ? strtolower($q) : '';
}

/**
 * Gera caminho do cache
 */
function cacheFile(string $query): string
{
    $safe = preg_replace('/[^a-z0-9_]/', '_', $query);
    return CACHE_DIR . "autocomplete_{$safe}.json";
}

/**
 * Lê cache se válido
 */
function lerCache(string $arquivo): ?array
{
    if (!file_exists($arquivo)) {
        return null;
    }

    if (time() - filemtime($arquivo) > CACHE_TTL) {
        unlink($arquivo);
        return null;
    }

    $conteudo = file_get_contents($arquivo);
    return json_decode($conteudo, true);
}

/**
 * Salva cache
 */
function salvarCache(string $arquivo, array $data): void
{
    file_put_contents(
        $arquivo,
        json_encode($data, JSON_UNESCAPED_UNICODE)
    );
}

/**
 * Busca autocomplete no Scryfall
 */
function buscarAutocompleteScryfall(string $query): array
{
    $url = 'https://api.scryfall.com/cards/autocomplete?q=' . urlencode($query);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: MTG-Acervo/1.0'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        curl_close($ch);
        return [];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return [];
    }

    $data = json_decode($response, true);
    return $data['data'] ?? [];
}

/**
 * Resposta padrão
 */
function responder(array $data): void
{
    echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

/* ===== Fluxo principal ===== */

$query = getQuery();

if ($query === '') {
    responder([]);
}

$arquivoCache = cacheFile($query);

// 1️⃣ tenta cache
$cache = lerCache($arquivoCache);
if ($cache !== null) {
    responder($cache);
}

// 2️⃣ busca API
$resultado = buscarAutocompleteScryfall($query);

// 3️⃣ salva cache
salvarCache($arquivoCache, $resultado);

// 4️⃣ responde
responder($resultado);
