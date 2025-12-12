<?php
$pdo = new PDO("mysql:host=localhost;dbname=banco_de_dados_teste;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
