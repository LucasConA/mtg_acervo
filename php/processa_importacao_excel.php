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

    // por código
    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE codigo = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    // nome em português
    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE nome_pt = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    // nome em inglês
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

/* ===============================
   PROCESSAMENTO
================================ */

$resultados = [];

foreach ($linhas as $linha) {

    $nome       = trim($linha['A']);
    $edicaoTxt  = trim($linha['B']);
    $raridade   = trim($linha['C']);
    $condicao   = trim($linha['D']);
    $idioma     = trim($linha['E']);
    $tipo       = trim($linha['F']);
    $foil       = strtolower(trim($linha['G'])) === 'foil' ? 1 : 0;
    $quantidade = (int)$linha['H'];

    // aceita vírgula ou ponto
    $valor = (float) str_replace(',', '.', $linha['I']);

    if ($nome === '') continue;

    // BUSCAS
    $id_edicao   = buscaEdicaoInteligente($pdo, $edicaoTxt);
    $id_raridade = buscaId($pdo, 'raridades', $raridade);
    $id_condicao = buscaId($pdo, 'condicao', $condicao);
    $id_idioma   = buscaId($pdo, 'idiomas', $idioma);
    $id_tipo     = buscaId($pdo, 'tipos', $tipo);

    if (!$id_edicao || !$id_raridade || !$id_condicao || !$id_idioma || !$id_tipo) {
        $resultados[] = "Linha ignorada: $nome (dados inválidos ou edição não encontrada)";
        continue;
    }

    // EVITA DUPLICATA
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
        $resultados[] = "Carta já existente: $nome";
        continue;
    }

    // INSERÇÃO
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

    $resultados[] = "Inserida: $nome";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Importação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #fff;
        }
        .box {
            max-width: 800px;
            margin: 40px auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
        }
        ul {
            max-height: 350px;
            overflow-y: auto;
        }
        a {
            display: inline-block;
            margin-right: 15px;
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            background: #333;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Importação finalizada</h2>

    <ul>
        <?php foreach ($resultados as $msg): ?>
            <li><?= htmlspecialchars($msg) ?></li>
        <?php endforeach; ?>
    </ul>

    <a href="../index.php">Adicionar carta</a>
    <a href="../colecao.php">Ver coleção</a>
</div>

</body>
</html>
