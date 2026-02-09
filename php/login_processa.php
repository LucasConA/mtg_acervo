<?php
session_start();
require __DIR__ . '/conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);

$user = $stmt->fetch();

if (!$user) {
    header("Location: login.php?erro=1");
    exit;
}

if (!password_verify($senha, $user['senha_hash'])) {
    header("Location: login.php?erro=1");
    exit;
}

/* LOGIN OK */
$_SESSION['usuario_id'] = $user['id'];
$_SESSION['usuario_nome'] = $user['nome'];

header("Location: index.php");
exit;
