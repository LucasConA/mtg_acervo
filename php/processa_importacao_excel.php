<?php
require 'conexao.php';
require  'mtg_acervo\vendor\autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// VERIFICA UPLOAD
if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0) {
    die("Erro: nenhum arquivo enviado.");
}

// VERIFICA EXTENSÃO
$arquivo = $_FILES['arquivo'];
$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
$permitidas = ['xlsx', 'xls', 'csv'];

if (!in_array($extensao, $permitidas)) {
    die("Erro: somente XLS, XLSX ou CSV são aceitos.");
}

// CARREGA ARQUIVO
$caminho = $arquivo['tmp_name'];
$planilha = IOFactory::load($caminho);
$sheet = $planilha->getActiveSheet();
$linhas = $sheet->toArray(null, true, true, true);

// PROCESSA LINHAS
$primeira = true;

foreach ($linhas as $linha) {
    if ($primeira) { $primeira = false; continue; }

    $nome       = $linha['A'];
    $edicao     = $linha['B'];
    $raridade   = $linha['C'];
    $condicao   = $linha['D'];
    $idioma     = $linha['E'];
    $tipo       = $linha['F'];
    $foil       = ($linha['G'] == 'foil') ? 1 : 0;
    $quantidade = (int)$linha['H'];
    $valor      = (float)$linha['I'];

    if (!$nome) continue;

    // BUSCA FK
    $fk = [
        'edicao'   => buscaId($pdo, 'edicoes', $edicao),
        'raridade' => buscaId($pdo, 'raridades', $raridade),
        'condicao' => buscaId($pdo, 'condicao', $condicao),
        'idioma'   => buscaId($pdo, 'idiomas', $idioma),
        'tipo'     => buscaId($pdo, 'tipos', $tipo)
    ];

    foreach ($fk as $campo => $valorFK) {
        if ($valorFK === null) {
            echo "⚠️ Linha ignorada: valor '$$campo' não existe no banco.<br>";
            continue 2;
        }
    }

    // EVITA DUPLICATAS
    $check = $pdo->prepare("
        SELECT id FROM cartas WHERE nome = ? AND id_edicao = ? AND id_idioma = ? AND id_tipo = ? AND foil = ?
    ");
    $check->execute([$nome, $fk['edicao'], $fk['idioma'], $fk['tipo'], $foil]);

    if ($check->fetch()) {
        echo "📌 Carta já existe (ignorada): $nome<br>";
        continue;
    }

    // INSERE
    $sql = $pdo->prepare("
        INSERT INTO cartas (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $sql->execute([$nome, ...array_values($fk), $foil, $quantidade, $valor]);

    echo "✔️ Inserida: $nome<br>";
}

// FUNÇÃO FK
function buscaId($pdo, $tabela, $nome) {
    $stmt = $pdo->prepare("SELECT id FROM $tabela WHERE nome = ?");
    $stmt->execute([$nome]);
    return $stmt->fetchColumn() ?: null;
}

echo "<hr>Importação finalizada!";
