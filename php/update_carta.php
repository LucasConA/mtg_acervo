<?php
require __DIR__ . '/../vendor/autoload.php';

use App\AcervoMtg\Http\Controller\CartaController;

$controller = new CartaController();
$controller->atualizar($_POST);

header("Location: /mtg_acervo/colecao.php?sucesso=update");
exit;
?>