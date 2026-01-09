<?php

require_once __DIR__ . '/../conexao.php';

function listarOpcoes(string $tabela, string $campoNome = 'nome'): array
{
    global $pdo;

    $sql = match ($tabela) {
        'edicoes' => "SELECT id, COALESCE(nome_pt, nome_en) AS nome FROM edicoes",
        default   => "SELECT id, nome FROM {$tabela}"
    };

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
