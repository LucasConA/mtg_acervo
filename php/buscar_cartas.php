<?php
require 'conexao.php';

function aplicarFiltros(&$sql, &$params, $filtros) {
    if (!empty($filtros['nome'])) {
        $sql .= " AND cartas.nome LIKE ?";
        $params[] = "%" . $filtros['nome'] . "%";
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

function buscarCartas(array $filtros): array {
    global $pdo;

    $baseSql = "
        FROM cartas
        JOIN edicoes ON cartas.id_edicao = edicoes.id
        JOIN raridades ON cartas.id_raridade = raridades.id
        JOIN condicao ON cartas.id_condicao = condicao.id
        JOIN idiomas ON cartas.id_idioma = idiomas.id
        JOIN tipos ON cartas.id_tipo = tipos.id
        WHERE 1 = 1
    ";

    $sql = "SELECT cartas.*, edicoes.nome AS edicao, raridades.nome AS raridade,
            condicao.nome AS condicao, idiomas.nome AS idioma, tipos.nome AS tipo
            $baseSql";

    $sqlTotal = "SELECT SUM(cartas.valor) AS total $baseSql";

    $params = [];
    $paramsTotal = [];

    aplicarFiltros($sql, $params, $filtros);
    aplicarFiltros($sqlTotal, $paramsTotal, $filtros);

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->execute($paramsTotal);
    $total = $stmtTotal->fetchColumn() ?? 0;

    return [$cartas, $total];
}
