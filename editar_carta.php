<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\EditarCartaController;
use App\AcervoMtg\Http\Controller\AtualizarCartaController;

try {

    // POST → atualizar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AtualizarCartaController();
        $controller->executar($_POST);

        header('Location: colecao.php');
        exit;
    }

    // GET → carregar dados
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
    <title>Editar Carta</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<h1>Editar Carta</h1>

<form method="post">

    <input type="hidden" name="id" value="<?= $carta['id'] ?>">

    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($carta['nome']) ?>" required>

    <label>Edição</label>
    <select name="edicao">
        <option value="<?= $carta['id_edicao'] ?>">
            <?= $carta['id_edicao'] ?>
        </option>
    </select>

    <label>Quantidade</label>
    <input type="number" name="quantidade" value="<?= $carta['quantidade'] ?>" min="0">

    <label>Valor</label>
    <input type="number" step="0.01" name="valor" value="<?= $carta['valor'] ?>">

    <label>
        <input type="checkbox" name="foil" <?= $carta['foil'] ? 'checked' : '' ?>>
        Foil
    </label>

    <button type="submit" class="botao">Salvar</button>
</form>

</div>
</body>
</html>
