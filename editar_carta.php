<?php
require_once __DIR__ . '/vendor/autoload.php';

define('BASE_URL', '/src/AcervoMtg');


use App\AcervoMtg\Http\Controller\EditarCartaController;
use App\AcervoMtg\Http\Controller\AtualizarCartaController;




try {

    // POST → atualizar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AtualizarCartaController();
        $controller->executar($_POST);

        header('Location: ' . BASE_URL . '/colecao.php');
        exit;
    }

    // GET → editar
    $controller = new EditarCartaController();
    $carta = $controller->executar($_GET);

} catch (Throwable $e) {
    die($e->getMessage());
}

    $data = $controller->executar($_GET);

    $carta     = $data['carta'];
    $edicoes   = $data['edicoes'];
    $raridades = $data['raridades'];
    $condicoes = $data['condicoes'];
    $idiomas   = $data['idiomas'];
    $tipos     = $data['tipos'];


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Carta - Acervo MTG</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header id="cabecalho">
    <h1>Editar Carta</h1>

    <nav id="menu">
        <a href="<?= BASE_URL ?>/colecao.php" class="botao">
            Voltar para a coleção
        </a>
    </nav>
</header>

<main>

<form method="post" action="<?= BASE_URL ?>/editar_carta.php" class="form-carta">

    <input type="hidden" name="id" value="<?= (int)$carta['id'] ?>">

    <label class="campoTitulo">Nome da carta</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($carta['nome']) ?>" required>

    <label class="campoTitulo">Edição</label>
    <select name="edicao" required>
    <?php foreach ($edicoes as $e): ?>
        <option value="<?= $e['id'] ?>"
            <?= $e['id'] === $carta['id_edicao'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($e['nome']) ?>
        </option>
    <?php endforeach; ?>
    </select>


    <label class="campoTitulo">Raridade</label>
    <select name="raridade" required>
    <?php foreach ($raridades as $r): ?>
        <option value="<?= $r['id'] ?>"
            <?= $r['id'] === $carta['id_raridade'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($r['nome']) ?>
        </option>
    <?php endforeach; ?>
    </select>



    <label class="campoTitulo">Condição</label>
    <select name="condicao" required>
    <?php foreach ($condicoes as $c): ?>
        <option value="<?= $c['id'] ?>"
            <?= $c['id'] === $carta['id_condicao'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['nome']) ?>
        </option>
    <?php endforeach; ?>
    </select>


    <label class="campoTitulo">Idioma</label>
    <select name="idioma" required>
    <?php foreach ($idiomas as $i): ?>
        <option value="<?= $i['id'] ?>"
            <?= $i['id'] === $carta['id_idioma'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($i['nome']) ?>
        </option>
    <?php endforeach; ?>
    </select>


    <label class="campoTitulo">Tipo</label>
    <select name="tipo" required>
    <?php foreach ($tipos as $t): ?>
        <option value="<?= $t['id'] ?>"
            <?= $t['id'] === $carta['id_tipo'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($t['nome']) ?>
        </option>
    <?php endforeach; ?>
    </select>


    <label class="campoTitulo">Foil</label>

        <label>
            <input type="radio" name="foil" value="1" <?= $carta['foil'] ? 'checked' : '' ?>>
            Sim
        </label>

        <label>
            <input type="radio" name="foil" value="0" <?= !$carta['foil'] ? 'checked' : '' ?>>
            Não
        </label>


    <label class="campoTitulo">Quantidade</label>
    <input type="number" name="quantidade" min="1" value="<?= (int)$carta['quantidade'] ?>" required>

    <label class="campoTitulo">Valor</label>
    <input type="number" step="0.01" name="valor" value="<?= htmlspecialchars($carta['valor']) ?>" required>

    <button type="submit" class="botao">Salvar alterações</button>

</form>

</main>

</div>
</body>
</html>
