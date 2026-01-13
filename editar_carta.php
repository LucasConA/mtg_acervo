<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\EditarCartaController;

try {
    $controller = new EditarCartaController();
    $carta = $controller->executar($_GET);
} catch (Throwable $e) {
    die($e->getMessage());
}
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
        <a href="/src/AcervoMtg/colecao.php" class="botao">
            Voltar para a coleção
        </a>
    </nav>
</header>

<main>

<form method="post" action="atualizar.php" class="form-carta">

    <input type="hidden" name="id" value="<?= (int)$carta['id'] ?>">

    <label class="campoTitulo">Nome da carta</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($carta['nome']) ?>" required>

    <label class="campoTitulo">Edição</label>
    <select name="edicao" required>
        <option value="<?= $carta['id_edicao'] ?>">
            <?= htmlspecialchars($carta['edicao_nome']) ?>
        </option>
    </select>

    <label class="campoTitulo">Raridade</label>
    <select name="raridade" required>
        <option value="<?= $carta['id_raridade'] ?>">
            <?= htmlspecialchars($carta['raridade_nome']) ?>
        </option>
    </select>

    <label class="campoTitulo">Condição</label>
    <select name="condicao" required>
        <option value="<?= $carta['id_condicao'] ?>">
            <?= htmlspecialchars($carta['condicao_nome']) ?>
        </option>
    </select>

    <label class="campoTitulo">Idioma</label>
    <select name="idioma" required>
        <option value="<?= $carta['id_idioma'] ?>">
            <?= htmlspecialchars($carta['idioma_nome']) ?>
        </option>
    </select>

    <label class="campoTitulo">Tipo</label>
    <select name="tipo" required>
        <option value="<?= $carta['id_tipo'] ?>">
            <?= htmlspecialchars($carta['tipo_nome']) ?>
        </option>
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
