<?php 
require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aviso - Acervo MTG</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>
<body>

<div id="interface">

    <header id="cabecalho">
        <h1>Acervo MTG</h1>
    </header>

    <section style="max-width:450px;margin:80px auto;text-align:center;">
        <h2 style="color:#d4af37;margin-bottom:20px;">Ação não Permitida</h2>
        <p style="color:#ddd;line-height:1.6;font-size:16px;">Você está no <strong>Modo de Demonstração (Visitante)</strong> e não tem permissão para alterar ou salvar dados no acervo.</p>
        <br>
        <p id="timer-text" style="color:#aaa;font-size:14px;">Redirecionando automaticamente em <span id="countdown" style="font-weight:bold;color:#d4af37;">5</span> segundos...</p>
        <br>
        <a href="<?= BASE_URL ?>/index.php" class="botao" style="display:inline-block;width:100%;text-decoration:none;box-sizing:border-box;text-align:center;">Voltar</a>
    </section>

</div>

<script>
    let seconds = 5;
    const countdownEl = document.getElementById('countdown');
    const interval = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(interval);
            window.location.href = "<?= BASE_URL ?>/index.php";
        }
    }, 1000);
</script>
</body>
</html>
