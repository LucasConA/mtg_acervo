<?php
declare(strict_types=1);

require __DIR__ . '/conexao.php';

/**
 * Carrega edições exibindo:
 * CODIGO – Nome (PT com fallback EN)
 */
$sql = "
    SELECT
        id,
        codigo,
        COALESCE(nome_pt, nome_en) AS nome
    FROM edicoes
    ORDER BY nome
";

$stmt = $pdo->query($sql);

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id     = (int) $linha['id'];
    $codigo = htmlspecialchars($linha['codigo']?? '', ENT_QUOTES, 'UTF-8');
    $nome   = htmlspecialchars($linha['nome']?? '', ENT_QUOTES, 'UTF-8');

    echo "<option value=\"{$id}\">{$nome}  ({$codigo})</option>";
}
