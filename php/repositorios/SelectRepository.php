<?php

require_once __DIR__ . '/../conexao.php';

function listarOpcoes(string $tabela): array
{
    global $pdo;

    $tabelasPermitidas = ['edicoes', 'raridades', 'condicao', 'idiomas', 'tipos'];

    if (!in_array($tabela, $tabelasPermitidas, true)) {
        throw new InvalidArgumentException('Tabela inválida');
    }

    $sql = match ($tabela) {
        'edicoes' => "
            SELECT id, COALESCE(nome_pt, nome_en) AS nome
            FROM edicoes
            ORDER BY nome
        ",
        default => "
            SELECT id, nome
            FROM {$tabela}
            ORDER BY nome
        "
    };

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
?>