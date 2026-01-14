<?php
require_once __DIR__ . '/vendor/autoload.php';

define('BASE_URL', '/src/AcervoMtg');

$mensagem = null;
$tipo = null;

if (isset($_GET['sucesso'])) {
    $mensagem = 'A carta foi adicionada à sua coleção com sucesso.';
    $tipo = 'sucesso';
}

if (isset($_GET['erro'])) {
    $mensagem = 'Ocorreu um erro ao salvar a carta. Tente novamente.';
    $tipo = 'erro';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acervo MTG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="_css/estilo.css">
</head>

<body>
<div id="interface">

<header id="cabecalho">
    <h1>Acervo MTG</h1>

    <?php if ($mensagem): ?>
        <div class="modal" id="modal-feedback">
            <div class="modal-box">
                <button class="fechar" onclick="fecharModal()">×</button>
                <h2><?= $tipo === 'sucesso' ? 'Sucesso' : 'Erro' ?></h2>
                <p><?= htmlspecialchars($mensagem) ?></p>
                <button class="botao" onclick="fecharModal()">OK</button>
            </div>
        </div>
    <?php endif; ?>

    <nav id="menu">
        <ul>
            <li>
                <a href="<?= BASE_URL ?>/colecao.php" class="botao">
                Minha Coleção
                </a>
            </li>
        </ul>
    </nav>
</header>

<?php include __DIR__. 'views/adicionar_form.php'; ?>
<?php include __DIR__. 'views/importar_form.php'; ?>
<?php include __DIR__. 'views/buscar_form.php'; ?>

<footer id="rodape"></footer>

</div>

<script src="_js/modal.js"></script>
<script src="_js/autocomplete.js" defer></script>
<script src="_js/buscar_ptbr.js" defer></script>
</body>
</html>
