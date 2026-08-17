<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/auth.php';

use App\AcervoMtg\Http\Controller\BuscarCartasController;


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
            <li>Olá, <?= $_SESSION['usuario_nome'] ?></li>
            <li>
                <a href="<?= BASE_URL ?>/colecao.php" class="botao">
                Minha Coleção
                </a>
            </li>
        </ul>

        <ul>

            <li><a href="<?= BASE_URL ?>/logout.php" class="botao">Sair</a></li>
        </ul>

    </nav>
</header>

<?php $filtros = [
    'nome'     => $_GET['busca_nome'] ?? '',
    'edicao'   => $_GET['busca_edicao'] ?? '',
    'raridade' => $_GET['busca_raridade'] ?? '',
    'tipo'     => $_GET['busca_tipo'] ?? '',
];

$cartas = [];
$totalFiltrado = 0;
$filtros = [];

if (!empty($_GET)) {
    $controllerBusca = new BuscarCartasController();
    $cartas = $controllerBusca->executar($_GET);

    $filtros = $_GET;

    foreach ($cartas as $c) {
        $totalFiltrado += ($c['valor'] * ($c['quantidade'] ?? 1));
    }
}
?>


<?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] === 0): ?>
    <div style="background-color: #5d2525; color: #ffb3b3; border: 1px solid #ff4d4d; padding: 10px; text-align: center; margin-bottom: 20px; border-radius: 4px; font-weight: bold;">
        Modo de Demonstração: Você não pode alterar a coleção de cartas.
    </div>
<?php endif; ?>

<?php include __DIR__. '/views/adicionar_form.php'; ?>
<?php include __DIR__. '/views/importar_form.php'; ?>
<?php include __DIR__. '/views/buscar_form.php'; ?>

<footer id="rodape"></footer>

</div>

<script src="_js/modal.js"></script>
<script src="_js/autocomplete.js" defer></script>
<script src="_js/buscar_ptbr.js" defer></script>
</body>
</html>
