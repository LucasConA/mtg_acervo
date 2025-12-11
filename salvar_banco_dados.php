<?php
//Dados enviados pelo formulário
$nomeCarta = $_POST['nomeCarta'];
$edicao = $_POST['nomeEdicao'];

//Conexão com MySQL
$pdo = new PDO("mysql:host=localhost;dbname=banco_de_dadosTeste", "root", "");

//Comando SQL para inserir variavel nos valores
$sql = $pdo->prepare("INSERT INTO usuarios (nome,email) VALUES (?,?)");
$sql->execute([$nomeCarta, $edicao]);

echo "Usuário cadastrado com sucesso!";

echo "<a href='index.html'>Voltar para o cadastro</a>";
?>