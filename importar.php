<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\AcervoMtg\Http\Controller\ImportacaoController;

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Método inválido');
    }

    $controller = new ImportacaoController();
    $controller->confirmar($_POST);

    header('Location: /src/AcervoMtg/colecao.php?sucesso=importar');
    exit;

} catch (Throwable $e) {
    header('Location: /src/AcervoMtg/colecao.php?erro=importar');
    exit;
}
