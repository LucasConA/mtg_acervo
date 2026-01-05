<?php
session_start();
require 'conexao.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

/* ========= FUNÇÕES ========= */

function buscaId(PDO $pdo, string $tabela, string $valor) {
    $sql = $pdo->prepare("SELECT id FROM $tabela WHERE nome = ?");
    $sql->execute([trim($valor)]);
    return $sql->fetchColumn() ?: null;
}

function buscaEdicaoInteligente(PDO $pdo, string $valor) {
    $valor = trim($valor);
    if ($valor === '') return null;

    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE codigo = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE nome_pt = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    $sql = $pdo->prepare("SELECT id FROM edicoes WHERE nome_en = ?");
    $sql->execute([$valor]);
    if ($id = $sql->fetchColumn()) return $id;

    return null;
}

/* ========= UPLOAD ========= */

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0) {
    die("Erro no upload.");
}

$planilha = IOFactory::load($_FILES['arquivo']['tmp_name']);
$sheet = $planilha->getActiveSheet();
$linhas = $sheet->toArray(null, true, true, true);

$preview = [];
$erros = [];

/* ========= LEITURA ========= */

foreach ($linhas as $i => $linha) {

    $nome       = trim($linha['A']);
    $edicaoTxt  = trim($linha['B']);
    $raridade   = trim($linha['C']);
    $condicao   = trim($linha['D']);
    $idioma     = trim($linha['E']);
    $tipo       = trim($linha['F']);
    $foil       = strtolower(trim($linha['G'])) === 'foil' ? 1 : 0;
    $quantidade = (int)$linha['H'];
    $valor      = (float) str_replace(',', '.', $linha['I']);

    if ($nome === '') continue;

    $id_edicao   = buscaEdicaoInteligente($pdo, $edicaoTxt);
    $id_raridade = buscaId($pdo, 'raridades', $raridade);
    $id_condicao = buscaId($pdo, 'condicao', $condicao);
    $id_idioma   = buscaId($pdo, 'idiomas', $idioma);
    $id_tipo     = buscaId($pdo, 'tipos', $tipo);

    if (!$id_edicao || !$id_raridade || !$id_condicao || !$id_idioma || !$id_tipo) {
        $erros[] = "Linha $i ignorada: $nome (dados inválidos)";
        continue;
    }

    $preview[] = [
        'nome' => $nome,
        'id_edicao' => $id_edicao,
        'id_raridade' => $id_raridade,
        'id_condicao' => $id_condicao,
        'id_idioma' => $id_idioma,
        'id_tipo' => $id_tipo,
        'foil' => $foil,
        'quantidade' => $quantidade,
        'valor' => $valor,
        'edicao_txt' => $edicaoTxt
    ];
}

/* guarda para a confirmação */
$_SESSION['preview_importacao'] = $preview;
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Preview da Importação</title>
<style>
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #444; padding: 6px; }
body { background:#121212; color:#fff; font-family:Arial; }
a, button { padding:10px 15px; background:#333; color:#fff; border:none; cursor:pointer; }
</style>
</head>
<body>

<h2>Preview da Importação</h2>

<?php if ($erros): ?>
<h3>Linhas ignoradas</h3>
<ul>
<?php foreach ($erros as $e): ?>
<li><?= htmlspecialchars($e) ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<table>
<tr>
    <th>Nome</th>
    <th>Edição</th>
    <th>Qtd</th>
    <th>Foil</th>
    <th>Valor</th>
</tr>
<?php foreach ($preview as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['nome']) ?></td>
    <td><?= htmlspecialchars($c['edicao_txt']) ?></td>
    <td><?= $c['quantidade'] ?></td>
    <td><?= $c['foil'] ? 'Sim' : 'Não' ?></td>
    <td><?= number_format($c['valor'], 2, ',', '.') ?></td>
</tr>
<?php endforeach; ?>
</table>

<form method="post" action="importar_confirmar.php">
    <button type="submit">Confirmar Importação</button>
    <a href="../index.php">Cancelar</a>
</form>

</body>
</html>



