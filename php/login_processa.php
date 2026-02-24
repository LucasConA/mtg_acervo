<?php
session_start();

require_once __DIR__ . '/../config.php';
require __DIR__ . '/conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);

$user = $stmt->fetch();

if (!$user) {
    header("Location: " . BASE_URL . "/login.php?erro=1");
    exit;
}

if (!password_verify($senha, $user['senha_hash'])) {
    header("Location: " . BASE_URL . "/login.php?erro=1");
    exit;
}

/* LOGIN OK */
$_SESSION['usuario_id'] = $user['id'];
$_SESSION['usuario_nome'] = $user['nome'];

header("Location: " . BASE_URL . "/index.php");
exit;
