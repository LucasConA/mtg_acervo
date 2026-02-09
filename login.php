<?php 
require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Acervo MTG</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/estilo.css">
</head>
<body>

<div id="interface">

    <header id="cabecalho">
        <h1>Acervo MTG</h1>
    </header>

    <section style="max-width:400px;margin:80px auto;">
        <h2 style="text-align:center;color:#d4af37;">Acesso ao sistema</h2>

        <?php if(isset($_GET['erro'])): ?>
            <div class="mensagem erro">Email ou senha inválidos</div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/php/login_processa.php">
            
            <label class="campoTitulo">Email</label>
            <input type="email" name="email" required>

            <label class="campoTitulo">Senha</label>
            <input type="password" name="senha" required>

            <br>
            <button class="botao" style="width:100%">Entrar</button>
        </form>
    </section>

</div>
</body>
</html>
