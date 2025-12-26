<?php
require 'conexao.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_FILES['arquivo_excel']) || $_FILES['arquivo_excel']['error'] !== 0) {
    die("Erro ao enviar o arquivo.");
}

$caminho = $_FILES['arquivo_excel']['tmp_name'];
$planilha = IOFactory::load($caminho);
$sheet = $planilha->getActiveSheet();
$linhas = $sheet->toArray(null, true, true, true);

$primeira = true;

foreach ($linhas as $linha) {
    if ($primeira) { $primeira = false; continue; } // pula cabeçalho

    $nome       = $linha['A'];
    $edicao     = $linha['B'];
    $raridade   = $linha['C'];
    $condicao   = $linha['D'];
    $idioma     = $linha['E'];
    $tipo       = $linha['F'];
    $foil       = ($linha['G'] == 'foil') ? 1 : 0;
    $quantidade = (int)$linha['H'];
    $valor      = (float)$linha['I'];

    if (!$nome) continue; // ignora linhas vazias

    // 🔎 Buscar IDs relacionados (ajustar conforme seu banco)
    $fk = [
        'edicao'   => buscaId($pdo, 'edicoes', $edicao),
        'raridade' => buscaId($pdo, 'raridades', $raridade),
        'condicao' => buscaId($pdo, 'condicao', $condicao),
        'idioma'   => buscaId($pdo, 'idiomas', $idioma),
        'tipo'     => buscaId($pdo, 'tipos', $tipo)
    ];

    $sql = $pdo->prepare("
        INSERT INTO cartas (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $sql->execute([
        $nome,
        $fk['edicao'],
        $fk['raridade'],
        $fk['condicao'],
        $fk['idioma'],
        $fk['tipo'],
        $foil,
        $quantidade,
        $valor
    ]);
}

function buscaId($pdo, $tabela, $nome) {
    $stmt = $pdo->prepare("SELECT id FROM $tabela WHERE nome = ?");
    $stmt->execute([$nome]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado['id'] : null;
}

echo "Importação concluída!";
