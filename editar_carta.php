<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\CartaController;
use App\AcervoMtg\Http\Controller\EditarCartaController;
use App\AcervoMtg\Http\Controller\AtualizarCartaController;

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AtualizarCartaController();
        $controller->executar($_POST);
        exit;
    }

    // GET
    $controller = new EditarCartaController();
    $carta = $controller->executar($_GET);

} catch (Throwable $e) {
    die($e->getMessage());
}

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

    <input type="text" name="nomeCarta" value="<?= htmlspecialchars($carta['nome']) ?>">

    <input type="number" name="quantidade" value="<?= $carta['quantidade'] ?>">

    <input type="number" step="0.01" name="valorCarta" value="<?= $carta['valor'] ?>">


    <!-- demais selects continuam iguais -->

    <button type="submit" class="botao">Salvar</button>
</form>

</div>
</body>
</html>
