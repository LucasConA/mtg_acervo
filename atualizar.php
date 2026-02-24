<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\AtualizarCartaController;

$controller = new AtualizarCartaController();

try {
    $controller->executar($_POST);
} catch (Throwable $e) {
    die($e->getMessage());
}
