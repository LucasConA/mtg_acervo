<?php
require 'conexao.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

/* ===============================
   FUNÇÕES
================================ */

function buscarId(PDO $pdo, string $tabela, string $valor)
{
    $tabelasPermitidas = ['raridades','condicao','idiomas','tipos'];
    if (!in_array($tabela, $tabelasPermitidas)) {
        throw new InvalidArgumentException('Tabela inválida');
    }

    $stmt = $pdo->prepare("SELECT id FROM {$tabela} WHERE nome = ?");
    $stmt->execute([trim($valor)]);
    return $stmt->fetchColumn() ?: null;
}

function buscarEdicao(PDO $pdo, string $valor) {
    $sql = $pdo->prepare("
        SELECT id
        FROM edicoes
        WHERE nome_pt = ? OR nome_en = ?
    ");
    $sql->execute([$valor, $valor]);
    return $sql->fetchColumn() ?: null;
}

function carregarEdicoes(PDO $pdo) {
    return $pdo->query("
        SELECT id, COALESCE(nome_pt, nome_en) AS nome
        FROM edicoes
        ORDER BY nome
    ")->fetchAll(PDO::FETCH_ASSOC);
}

function carregarTabela(PDO $pdo, string $tabela) {
    return $pdo->query("
        SELECT id, nome
        FROM $tabela
        ORDER BY nome
    ")->fetchAll(PDO::FETCH_ASSOC);
}

/* ===============================
   UPLOAD
================================ */

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0) {
    die("Arquivo inválido.");
}

$planilha = IOFactory::load($_FILES['arquivo']['tmp_name']);
$linhas   = $planilha->getActiveSheet()->toArray(null, true, true, true);

/* ===============================
   DROPDOWNS
================================ */

$edicoes   = carregarEdicoes($pdo);
$raridades = carregarTabela($pdo, 'raridades');
$condicoes = carregarTabela($pdo, 'condicao');
$idiomas   = carregarTabela($pdo, 'idiomas');
$tipos     = carregarTabela($pdo, 'tipos');

/* ===============================
   PROCESSAMENTO
================================ */

$preview = [];
$errosGlobais = [];
$linhaNum = 1;

foreach ($linhas as $linha) {

    $nome = trim($linha['A'] ?? '');
    if ($nome === '') { $linhaNum++; continue; }

    $edicaoTxt = trim($linha['B'] ?? '');
    $rarTxt    = trim($linha['C'] ?? '');
    $condTxt   = trim($linha['D'] ?? '');
    $idiTxt    = trim($linha['E'] ?? '');
    $tipoTxt   = trim($linha['F'] ?? '');
    $foilTxt   = strtolower(trim($linha['G'] ?? 'normal'));
    $qtd       = (int)($linha['H'] ?? 1);
    $valor     = str_replace(',', '.', $linha['I'] ?? 0);

    $idEdicao   = buscarEdicao($pdo, $edicaoTxt);
    $idRaridade = buscarId($pdo, 'raridades', $rarTxt);
    $idCondicao = buscarId($pdo, 'condicao', $condTxt);
    $idIdioma   = buscarId($pdo, 'idiomas', $idiTxt);
    $idTipo     = buscarId($pdo, 'tipos', $tipoTxt);

    $erros = [];
    $campos = [
        'Edição'   => $idEdicao,
        'Raridade' => $idRaridade,
        'Condição' => $idCondicao,
        'Idioma'   => $idIdioma,
        'Tipo'     => $idTipo
    ];

    foreach ($campos as $nomeCampo => $valorCampo) {
        if (!$valorCampo) $erros[] = "$nomeCampo inválido";
    }

    if ($erros) {
        $errosGlobais[] = "Linha $linhaNum: " . implode(', ', $erros);
    }

    $preview[] = [
        'nome' => $nome,
        'edicao' => $idEdicao,
        'raridade' => $idRaridade,
        'condicao' => $idCondicao,
        'idioma' => $idIdioma,
        'tipo' => $idTipo,
        'foil' => $foilTxt === 'foil' ? 1 : 0,
        'quantidade' => max(1, $qtd),
        'valor' => (float)$valor
    ];

    $linhaNum++;
}

/* ===============================
   BLOQUEIA SE HÁ ERROS
================================ */

if ($errosGlobais) {
    echo "<h2>Erro na importação</h2>";
    echo "<p>O arquivo contém erros e não pode ser importado.</p>";
    echo "<ul>";
    foreach ($errosGlobais as $e) echo "<li>$e</li>";
    echo "</ul>";
    echo "<a href='../index.php'>Voltar</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Preview da Importação</title>
    <link rel="stylesheet" href="../_css/estilo.css">
</head>
<body>

<div id="interface">

<header id="cabecalho">
    <h1>MTG Acervo</h1>
    <nav id="menu">
        <ul>
            <li><a href="../index.php">Voltar</a></li>
            <li><a href="../colecao.php">Coleção</a></li>
        </ul>
    </nav>
</header>

<h1>Preview da Importação</h1>

<form method="post" action="importar_confirmar.php">

<table id="preview-importacao">
<tr>
    <th>Nome</th>
    <th>Edição</th>
    <th>Raridade</th>
    <th>Condição</th>
    <th>Idioma</th>
    <th>Tipo</th>
    <th>Foil</th>
    <th>Qtd</th>
    <th>Valor</th>
</tr>

<?php foreach ($preview as $i => $c): ?>
<tr>
    <td>
        <input type="text" name="cartas[<?= $i ?>][nome]" value="<?= htmlspecialchars($c['nome']) ?>">
    </td>

    <td>
        <select name="cartas[<?= $i ?>][edicao]">
            <?php foreach ($edicoes as $e): ?>
                <option value="<?= $e['id'] ?>" <?= $e['id']==$c['edicao']?'selected':'' ?>>
                    <?= htmlspecialchars($e['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>

    <?php
    $map = [
        'raridade' => $raridades,
        'condicao' => $condicoes,
        'idioma'   => $idiomas,
        'tipo'     => $tipos
    ];
    foreach ($map as $campo => $lista):
    ?>
    <td>
        <select name="cartas[<?= $i ?>][<?= $campo ?>]">
            <?php foreach ($lista as $op): ?>
                <option value="<?= $op['id'] ?>" <?= $op['id']==$c[$campo]?'selected':'' ?>>
                    <?= htmlspecialchars($op['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
    <?php endforeach; ?>

    <td>
        <select name="cartas[<?= $i ?>][foil]">
            <option value="0" <?= !$c['foil']?'selected':'' ?>>Normal</option>
            <option value="1" <?= $c['foil']?'selected':'' ?>>Foil</option>
        </select>
    </td>

    <td>
        <input type="number" name="cartas[<?= $i ?>][quantidade]" min="1" value="<?= $c['quantidade'] ?>">
    </td>

    <td>
        <input type="number" step="0.01" name="cartas[<?= $i ?>][valor]" value="<?= $c['valor'] ?>">
    </td>
</tr>
<?php endforeach; ?>
</table>

<br>

<button type="submit" class="botao">Confirmar Importação</button>
<a href="../index.php" class="botao">Cancelar</a>

</form>

</div>
</body>
</html>
