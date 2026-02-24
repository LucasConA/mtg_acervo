<?php
require "conexao.php";

$sql = $pdo->query("SELECT id, nome FROM raridades ORDER BY id");
while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='{$linha['id']}'>{$linha['nome']}</option>";
}
?>
