<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST" action="login_processa.php">
    <input type="email" name="email" placeholder="Email" required>
    <br><br>
    <input type="password" name="senha" placeholder="Senha" required>
    <br><br>
    <button type="submit">Entrar</button>
</form>

<?php if(isset($_GET['erro'])): ?>
    <p style="color:red">Email ou senha inválidos</p>
<?php endif; ?>

</body>
</html>
