<?php
require_once __DIR__ . '/config.php';
session_start();
if (isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === 0) {
    header("Location: " . BASE_URL . "/aviso.php");
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\AtualizarCartaController;

$controller = new AtualizarCartaController();

try {
    $controller->executar($_POST);
} catch (Throwable $e) {
    die($e->getMessage());
}
