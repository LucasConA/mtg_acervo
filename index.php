<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="_css/estilo.css">
    <title>Acervo MTG</title>
</head>

<script>
function fecharSucesso() {
    document.getElementById('modal-sucesso').remove();
    history.replaceState(null, '', '/mtg_acervo/');
}
</script>



<body>
<div id="interface">
    <header id="cabecalho"> 
       <h1> Acervo MTG</h1> 
       <nav id="menu">
            <ul>
                <li><a href="/mtg_acervo/colecao.php" class="botao">Minha Coleção</a></li>

            </ul>
       </nav>
    </header>  

<?php if (isset($_GET['sucesso'])): ?>
    <div class="mensagem sucesso">
        Carta adicionada à coleção com sucesso!
    </div>

<?php elseif (isset($_GET['erro']) && $_GET['erro'] === 'campo'): ?>
    <div class="mensagem erro">
        Preencha todos os campos obrigatórios antes de salvar.
    </div>

<?php elseif (isset($_GET['erro']) && $_GET['erro'] === 'banco'): ?>
    <div class="mensagem erro">
        Ocorreu um erro ao salvar a carta. Tente novamente.
    </div>
<?php endif; ?>


<!-- Adicionar -->
    <h1>Adicionar a Coleção</h1> 
    <form method="post" action="php/salvar_banco_dados.php">
    <span class="campoTitulo">Nome:</span> <input type="text" name="nomeCarta" required><br>

    <span class="campoTitulo">Edição:</span>
    <select name="nomeEdicao">
        <option value="">Selecione</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select><br>

    <span class="campoTitulo">Raridade:</span>
    <select name="raridade" required>
        <?php include 'php/carregar_raridades.php'; ?>
    </select><br>

    <span class="campoTitulo">Condição:</span>
    <select name="condicao">
        <?php include 'php/carregar_condicoes.php'; ?>
    </select><br>

    <span class="campoTitulo">Idioma:</span>
    <select name="idioma">
        <?php include 'php/carregar_idiomas.php'; ?>
    </select><br>

    <span class="campoTitulo">Tipo:</span>
    <select name="tipo" required>
        <?php include 'php/carregar_tipos.php'; ?>
    </select><br>

    <span class="campoTitulo">Foil:</span>

    <div class="radio-grupo">
        <label>
            <input type="radio" name="foil" value="normal" checked>
            Normal
        </label>

        <label>
            <input type="radio" name="foil" value="foil">
            Foil
        </label>
    </div>

    
    <span class="campoTitulo">Quantidade:</span>
    <input type="number" name="quantidade" min="1" value="1"><br>


    <span class="campoTitulo">Valor R$:</span> <input type="number" name="valorCarta" step="0.01" min="0"><br>

    <button type="submit" class="botao">Adicionar carta</button>
</form>

<h2>Importar cartas via Excel</h2>

<form action="php/processa_importacao_excel.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo" accept=".xlsx,.xls" required>
    <button type="submit" class="botao">Importar</button>
</form>



<section id="busca-cartas">

    <hr>

<!-- Buscar -->
<h1>Buscar cartas na coleção</h1>

<form method="get" action="#busca-cartas">

    <!-- Define o nome da carta-->
    <span class="campoTitulo">Nome:</span>
    <input type="text" name="busca_nome"
           value="<?= $_GET['busca_nome'] ?? '' ?>"><br>

    <!-- Define a edição da carta -->
    <span class="campoTitulo">Edição:</span>
    <select name="busca_edicao">
        <option value="">Todas</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select><br>

        <!-- Define a raridade da carta -->
    <span class="campoTitulo">Raridade:</span>
    <select name="busca_raridade">
        <option value="">Todas</option>
        <?php include 'php/carregar_raridades.php'; ?>
    </select><br>
    <!-- Define o tipo da carta -->
    <span class="campoTitulo">Tipo:</span>
    <select name="busca_tipo">
        <option value="">Todos</option>
        <?php include 'php/carregar_tipos.php'; ?>
    </select><br>

    <button type="submit" class="botao">Buscar</button>

</form>
    <?php
if (
    !empty($_GET['busca_nome']) ||
    !empty($_GET['busca_edicao']) ||
    !empty($_GET['busca_raridade']) ||
    !empty($_GET['busca_tipo'])
) 
    {

    require 'php/conexao.php';

    $sql = "
        SELECT 
            cartas.id,
            cartas.nome,
            edicoes.nome AS edicao,
            raridades.nome AS raridade,
            condicao.nome AS condicao,
            idiomas.nome AS idioma,
            tipos.nome AS tipo,
            cartas.foil,
            cartas.valor
        FROM cartas
        JOIN edicoes ON cartas.id_edicao = edicoes.id
        JOIN raridades ON cartas.id_raridade = raridades.id
        JOIN condicao ON cartas.id_condicao = condicao.id
        JOIN idiomas ON cartas.id_idioma = idiomas.id
        JOIN tipos ON cartas.id_tipo = tipos.id
        WHERE 1 = 1
    ";

    $sqlTotal = "
    SELECT SUM(cartas.valor) AS total
    FROM cartas
    JOIN edicoes ON cartas.id_edicao = edicoes.id
    JOIN raridades ON cartas.id_raridade = raridades.id
    JOIN condicao ON cartas.id_condicao = condicao.id
    JOIN idiomas ON cartas.id_idioma = idiomas.id
    JOIN tipos ON cartas.id_tipo = tipos.id
    WHERE 1 = 1
    ";


    $params = [];
    $paramsTotal = [];

    if (!empty($_GET['busca_nome'])) {
        $sql .= " AND cartas.nome LIKE ?";
        $sqlTotal .= " AND cartas.nome LIKE ?";
        $params[] = "%" . $_GET['busca_nome'] . "%";
        $paramsTotal[] = "%" . $_GET['busca_nome'] . "%";
    }

    if (!empty($_GET['busca_edicao'])) {
        $sql .= " AND cartas.id_edicao = ?";
        $sqlTotal .= " AND cartas.id_edicao = ?";
        $params[] = $_GET['busca_edicao'];
        $paramsTotal[] = $_GET['busca_edicao'];
    }

    if (!empty($_GET['busca_raridade'])) {
        $sql .= " AND cartas.id_raridade = ?";
        $sqlTotal .= " AND cartas.id_raridade = ?";
        $params[] = $_GET['busca_raridade'];
        $paramsTotal[] = $_GET['busca_raridade'];
    }

    if (!empty($_GET['busca_tipo'])) {
        $sql .= " AND cartas.id_tipo = ?";
        $sqlTotal .= " AND cartas.id_tipo = ?";
        $params[] = $_GET['busca_tipo'];
        $paramsTotal[] = $_GET['busca_tipo'];
    }




    // Busca as cartas
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $cartas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Busca o total filtrado
    $stmtTotal = $pdo->prepare($sqlTotal);
    $stmtTotal->execute($paramsTotal);
    $totalFiltrado = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    }
?>
    <?php if (!empty($cartas)): ?>

<hr>
<h2>Resultado da busca</h2>

<table border="1" cellpadding="6">
    <tr>
        <th>Nome</th>
        <th>Edição</th>
        <th>Raridade</th>
        <th>Condição</th>
        <th>Idioma</th>
        <th>Tipo</th>
        <th>Foil</th>
        <th>Valor</th>
    </tr>

    <?php foreach ($cartas as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['nome']) ?></td>
            <td><?= $c['edicao'] ?></td>
            <td><?= $c['raridade'] ?></td>
            <td><?= $c['condicao'] ?></td>
            <td><?= $c['idioma'] ?></td>
            <td><?= $c['tipo'] ?></td>
            <td><?= $c['foil'] ? 'Foil' : 'Normal' ?></td>
            <td>R$ <?= number_format($c['valor'], 2, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
    <tfoot>
    <tr>
        <td colspan="7" style="text-align:left; font-weight:bold;">
            Valor total
        </td>
        <td style="font-weight:bold; color:#d4af37;">
            R$ <?= number_format($totalFiltrado, 2, ',', '.') ?>
        </td>
    </tr>
    </tfoot>
</table>
    


<?php elseif (!empty($_GET)): ?>
    <p><h2>Nenhuma carta encontrada.</h2></p>
<?php endif; ?>

 

    <footer id="rodape">

    </footer>
</div>
</body>
</html>