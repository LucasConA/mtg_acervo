<?php
require_once __DIR__ . '/conexao.php';

/**
 * Lista cartas da coleção com ordenação opcional
 *
 * @param string|null $ordem
 * @return array{0: array, 1: float}
 */
function listarCartas(?string $ordem): array
{
    global $pdo;

    $orderBy = match ($ordem) {
        'valor_asc'  => 'cartas.valor ASC',
        'valor_desc' => 'cartas.valor DESC',
        'nome_asc'   => 'cartas.nome ASC',
        'nome_desc'  => 'cartas.nome DESC',
        default      => 'cartas.nome ASC',
    };

    $sql = "
        SELECT
            cartas.id,
            cartas.nome AS carta,
            COALESCE(edicoes.nome_pt, edicoes.nome_en) AS edicao,
            raridades.nome AS raridade,
            condicao.nome AS condicao,
            idiomas.nome AS idioma,
            tipos.nome AS tipo,
            cartas.foil,
            cartas.quantidade,
            cartas.valor
        FROM cartas
        JOIN edicoes ON cartas.id_edicao = edicoes.id
        JOIN raridades ON cartas.id_raridade = raridades.id
        JOIN condicao ON cartas.id_condicao = condicao.id
        JOIN idiomas ON cartas.id_idioma = idiomas.id
        JOIN tipos ON cartas.id_tipo = tipos.id
        ORDER BY $orderBy
    ";

    $stmt = $pdo->query($sql);
    $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotal = $pdo->query("
        SELECT SUM(valor * quantidade) FROM cartas
    ");

    $total = $stmtTotal->fetchColumn() ?? 0;

    return [$cartas, $total];
}
