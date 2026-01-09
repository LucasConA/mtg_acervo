<?php

require_once __DIR__ . '/../conexao.php';

function buscarCartaPorId(int $id): array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM cartas WHERE id = ?");
    $stmt->execute([$id]);

    $carta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$carta) {
        throw new RuntimeException('Carta não encontrada');
    }

    return $carta;
}
