<?php
require "conexao.php";

$sql = $pdo->query("SELECT id, nome FROM tipos ORDER BY nome");
while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='{$linha['id']}'>{$linha['nome']}</option>";
}
?>
