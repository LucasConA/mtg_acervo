<?php
require 'conexao.php';

function listarCondicoes(PDO $pdo): array
{
    $stmt = $pdo->query("
        SELECT id, nome
        FROM condicao
        ORDER BY id
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

foreach (listarCondicoes($pdo) as $condicao): ?>
    <option value="<?= $condicao['id'] ?>">
        <?= htmlspecialchars($condicao['nome']) ?>
    </option>
<?php endforeach; ?>
