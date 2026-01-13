<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\CartaController;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('ID inválido');
}

$controller = new CartaController();

try {
    $carta = $controller->buscar($id);
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

<form method="post" action="/mtg_acervo/atualizar.php">
    <input type="hidden" name="id" value="<?= $carta['id'] ?>">

    <label>Nome</label>
    <input type="text" name="nomeCarta" value="<?= htmlspecialchars($carta['nome']) ?>">

    <label>Quantidade</label>
    <input type="number" name="quantidade" value="<?= $carta['quantidade'] ?>">

    <label>Valor</label>
    <input type="text" name="valorCarta" value="<?= $carta['valor'] ?>">

    <!-- demais selects continuam iguais -->

    <button type="submit" class="botao">Salvar</button>
</form>

</div>
</body>
</html>
