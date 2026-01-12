<?php
require __DIR__ . '/../vendor/autoload.php';

use App\AcervoMtg\Http\Controller\CartaController;

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("ID inválido");
}

$controller = new CartaController();
$controller->excluir($id);

header("Location: /mtg_acervo/colecao.php?sucesso=delete");
exit;
?>