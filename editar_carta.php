<?php
require_once 'php/repositorios/CartaRepository.php';
require_once 'php/repositorios/SelectRepository.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ID inválido');
}

try {
    $carta = buscarCartaPorId($id);
} catch (RuntimeException $e) {
    die($e->getMessage());
}

$edicoes   = listarOpcoes('edicoes');
$raridades = listarOpcoes('raridades');
$condicoes = listarOpcoes('condicao');
$idiomas   = listarOpcoes('idiomas');
$tipos     = listarOpcoes('tipos');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Carta</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>
<body>

<div id="interface">

<header id="cabecalho">
    <h1>Editar Carta</h1>
    <nav id="menu">
        <a href="/mtg_acervo/colecao.php" class="botao">Voltar</a>
    </nav>
</header>

<form method="post" action="php/update_carta.php">

<input type="hidden" name="id" value="<?= $carta['id'] ?>">

<span class="campoTitulo">Nome:</span>
<input type="text" name="nomeCarta"
       value="<?= htmlspecialchars($carta['nome']) ?>" required><br>

<?php
function renderSelect(string $name, array $opcoes, int $selecionado)
{
    echo "<select name='{$name}' required>";
    foreach ($opcoes as $opcao) {
        $selected = $opcao['id'] === $selecionado ? 'selected' : '';
        echo "<option value='{$opcao['id']}' {$selected}>{$opcao['nome']}</option>";
    }
    echo "</select><br>";
}
?>

<span class="campoTitulo">Edição:</span>
<?php renderSelect('id_edicao', $edicoes, $carta['id_edicao']); ?>

<span class="campoTitulo">Raridade:</span>
<?php renderSelect('id_raridade', $raridades, $carta['id_raridade']); ?>

<span class="campoTitulo">Condição:</span>
<?php renderSelect('id_condicao', $condicoes, $carta['id_condicao']); ?>

<span class="campoTitulo">Idioma:</span>
<?php renderSelect('id_idioma', $idiomas, $carta['id_idioma']); ?>

<span class="campoTitulo">Tipo:</span>
<?php renderSelect('id_tipo', $tipos, $carta['id_tipo']); ?>

<div class="radio-grupo">
    <label>
        <input type="radio" name="foil" value="0" <?= !$carta['foil'] ? 'checked' : '' ?>>
        Normal
    </label>
    <label>
        <input type="radio" name="foil" value="1" <?= $carta['foil'] ? 'checked' : '' ?>>
        Foil
    </label>
</div>

<span class="campoTitulo">Quantidade:</span>
<input type="number" name="quantidade" min="1"
       value="<?= $carta['quantidade'] ?>"><br>

<span class="campoTitulo">Valor R$:</span>
<input type="number" name="valorCarta" step="0.01" min="0"
       value="<?= $carta['valor'] ?>"><br>

<button type="submit" class="botao">Salvar Alterações</button>

</form>

</div>
</body>
</html>
