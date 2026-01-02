<?php
require "conexao.php";

$sql = $pdo->query("
    SELECT 
    id,
    CONCAT(
        COALESCE(nome_pt, nome_en),
        ' (',
        codigo,
        ')'
    ) AS nome_exibicao
FROM edicoes
ORDER BY nome_exibicao

");

while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='{$linha['id']}'>
            {$linha['nome_exibicao']}
          </option>";
}
?>
