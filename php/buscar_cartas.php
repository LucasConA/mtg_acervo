<?php
require 'conexao.php';

/**
 * Aplica filtros dinâmicos na query
 */
function aplicarFiltros(string &$sql, array &$params, array $filtros): void
{
    if (!empty($filtros['nome'])) {
        $sql .= " AND cartas.nome LIKE ?";
        $params[] = '%' . $filtros['nome'] . '%';
    }

    if (!empty($filtros['edicao'])) {
        $sql .= " AND cartas.id_edicao = ?";
        $params[] = $filtros['edicao'];
    }

    if (!empty($filtros['raridade'])) {
        $sql .= " AND cartas.id_raridade = ?";
        $params[] = $filtros['raridade'];
    }

    if (!empty($filtros['tipo'])) {
        $sql .= " AND cartas.id_tipo = ?";
        $params[] = $filtros['tipo'];
    }
}

/**
 * Busca cartas da coleção com filtros
 */
function buscarCartas(array $filtros): array
{
    global $pdo;

    $baseSql = "
        FROM cartas
        INNER JOIN edicoes   ON cartas.id_edicao   = edicoes.id
        INNER JOIN raridades ON cartas.id_raridade = raridades.id
        INNER JOIN condicao  ON cartas.id_condicao = condicao.id
        INNER JOIN idiomas   ON cartas.id_idioma   = idiomas.id
        INNER JOIN tipos     ON cartas.id_tipo     = tipos.id
        WHERE 1 = 1
    ";

    $sqlCartas = "
        SELECT
            cartas.*,
            COALESCE(edicoes.nome_pt, edicoes.nome_en) AS edicao,
            raridades.nome AS raridade,
            condicao.nome  AS condicao,
            idiomas.nome   AS idioma,
            tipos.nome     AS tipo
        $baseSql
    ";

    $sqlTotal = "
        SELECT SUM(cartas.valor * cartas.quantidade) AS total
        $baseSql
    ";

    $paramsCartas = [];
    $paramsTotal  = [];

    aplicarFiltros($sqlCartas, $paramsCartas, $filtros);
    aplicarFiltros($sqlTotal,  $paramsTotal,  $filtros);

    // Cartas
    $stmt = $pdo->prepare($sqlCartas);
    $stmt->execute($paramsCartas);
    $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total
    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->execute($paramsTotal);
    $total = $stmtTotal->fetchColumn() ?? 0;

    return [$cartas, $total];
}
