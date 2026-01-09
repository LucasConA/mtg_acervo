<form method="get" action="#busca-cartas">

    <span class="campoTitulo">Nome:</span>
    <input type="text" name="busca_nome"
           value="<?= htmlspecialchars($_GET['busca_nome'] ?? '') ?>">

    <span class="campoTitulo">Edição:</span>
    <select name="busca_edicao">
        <option value="">Todas</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select>

    <span class="campoTitulo">Raridade:</span>
    <select name="busca_raridade">
        <option value="">Todas</option>
        <?php include 'php/carregar_opcoes.php?tabela=raridades'; ?>
    </select>

    <span class="campoTitulo">Tipo:</span>
    <select name="busca_tipo">
        <option value="">Todos</option>
        <?php include 'php/carregar_opcoes.php?tabela=tipos'; ?>
    </select>

    <button type="submit" class="botao">Buscar</button>

</form>
