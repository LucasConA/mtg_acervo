<?php
require "conexao.php";

$idiomaPadrao = 2; // Define o idioma português como padrão no dropdown

$sql = $pdo->query("SELECT id, nome FROM idiomas ORDER BY nome");

while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
    $selected = ($linha['id'] == $idiomaPadrao) ? "selected" : "";
    echo "<option value='{$linha['id']}' $selected>{$linha['nome']}</option>";
}
?>
