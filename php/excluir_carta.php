<?php
declare(strict_types=1);

require __DIR__ . '/conexao.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(400);
    die('ID inválido.');
}

try {
    $pdo->beginTransaction();

    $check = $pdo->prepare("SELECT id FROM cartas WHERE id = ?");
    $check->execute([$id]);

    if (!$check->fetch()) {
        throw new RuntimeException('Carta não encontrada.');
    }

    $delete = $pdo->prepare("DELETE FROM cartas WHERE id = ?");
    $delete->execute([$id]);

    $pdo->commit();

    header("Location: /mtg_acervo/colecao.php?sucesso=excluido");
    exit;

} catch (Throwable $e) {
    $pdo->rollBack();
    http_response_code(500);
    die("Erro ao excluir: " . $e->getMessage());
}

?>