<?php
require 'conexao.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

/* ===============================
   FUNÇÕES
================================ */

// busca padrão por nome
function buscaId(PDO $pdo, string $tabela, string $valor) {
    $sql = $pdo->prepare("SELECT id FROM $tabela WHERE nome = ?");
    $sql->execute([trim($valor)]);
    return $sql->fetchColumn() ?: null;
}

// busca inteligente de edição
function buscaEdicaoInteligente(PDO $pdo, string $valor) {
    $valor = trim($valor);
    if ($valor === '') return null;

    // 1️⃣ por código
    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE codigo = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    // 2️⃣ nome em português
    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE nome_pt = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    // 3️⃣ nome em inglês
    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE nome_en = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    return null;
}

/* ===============================
   UPLOAD
================================ */

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0) {
    die("Erro: nenhum arquivo enviado.");
}

$arquivo = $_FILES['arquivo'];
$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
$permitidas = ['xlsx', 'xls', 'csv'];

if (!in_array($extensao, $permitidas)) {
    die("Erro: somente XLS, XLSX ou CSV são aceitos.");
}

/* ===============================
   LEITURA DA PLANILHA
================================ */

$planilha = IOFactory::load($arquivo['tmp_name']);
$sheet = $planilha->getActiveSheet();
$linhas = $sheet->toArray(null, true, true, true);

$primeira = true;

/* ===============================
   PROCESSAMENTO
================================ */

foreach ($linhas as $linha) {

    if ($primeira) { $primeira = false; continue; }

    $nome       = trim($linha['A']);
    $edicaoTxt  = trim($linha['B']);
    $raridade   = trim($linha['C']);
    $condicao   = trim($linha['D']);
    $idioma     = trim($linha['E']);
    $tipo       = trim($linha['F']);
    $foil       = strtolower(trim($linha['G'])) === 'foil' ? 1 : 0;
    $quantidade = (int)$linha['H'];
    $valor      = (float)$linha['I'];

    if ($nome === '') continue;

    //  BUSCAS
    $id_edicao   = buscaEdicaoInteligente($pdo, $edicaoTxt);
    $id_raridade = buscaId($pdo, 'raridades', $raridade);
    $id_condicao = buscaId($pdo, 'condicao', $condicao);
    $id_idioma   = buscaId($pdo, 'idiomas', $idioma);
    $id_tipo     = buscaId($pdo, 'tipos', $tipo);

    // validação
    if (!$id_edicao || !$id_raridade || !$id_condicao || !$id_idioma || !$id_tipo) {
        echo " Linha ignorada: edição '{$edicaoTxt}' ou dados inválidos.<br>";
        continue;
    }

    // evita duplicata
    $check = $pdo->prepare("
        SELECT id FROM cartas
        WHERE nome = ?
          AND id_edicao = ?
          AND id_idioma = ?
          AND id_tipo = ?
          AND foil = ?
    ");
    $check->execute([$nome, $id_edicao, $id_idioma, $id_tipo, $foil]);

    if ($check->fetch()) {
        echo "📌 Carta já existe: $nome<br>";
        continue;
    }

    // inserção
    $insert = $pdo->prepare("
        INSERT INTO cartas
        (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $insert->execute([
        $nome,
        $id_edicao,
        $id_raridade,
        $id_condicao,
        $id_idioma,
        $id_tipo,
        $foil,
        $quantidade,
        $valor
    ]);

    echo "Inserida: $nome<br>";
}

echo "<hr>Importação finalizada!";
