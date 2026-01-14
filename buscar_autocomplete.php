<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\BuscarCartaAutocompleteController;

header('Content-Type: application/json; charset=utf-8');

$termo = trim($_GET['q'] ?? '');

$controller = new BuscarCartaAutocompleteController();

try {
    echo json_encode($controller->executar($termo));
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([]);
}
