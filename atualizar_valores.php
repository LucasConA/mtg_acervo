<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/auth.php';

if (isset($_SESSION['usuario_id']) && (int)$_SESSION['usuario_id'] === 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'error' => 'Ação não permitida para visitantes.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

use App\AcervoMtg\Http\Controller\AtualizarValoresController;

$controller = new AtualizarValoresController();

// Check if request is JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() === JSON_ERROR_NONE) {
    $controller->executar($data);
} else {
    $controller->executar($_POST);
}
