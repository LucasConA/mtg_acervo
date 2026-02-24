<?php

require_once __DIR__ . '/config.php';

$arquivo = BASE_PATH . '/assets/modelos/modelo_importacao_cartas.xlsx';

if (!file_exists($arquivo)) {
    http_response_code(404);
    exit('Arquivo não encontrado');
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="modelo_importacao_cartas.xlsx"');
header('Content-Length: ' . filesize($arquivo));

readfile($arquivo);
exit;
