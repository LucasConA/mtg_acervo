<?php
require_once __DIR__ . '/../conexao.php';

function buscarCartaPorId(int $id): array
{
    global $pdo;

    $sql = "
        SELECT
            id,
            nome,
            id_edicao,
            id_raridade,
            id_condicao,
            id_idioma,
            id_tipo,
            foil,
            quantidade,
            valor
        FROM cartas
        WHERE id = ?
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $carta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carta) {
        throw new RuntimeException('Carta não encontrada');
    }

    return $carta;
}
?>