<h2>Adicionar à coleção</h2>

<form method="post" action="php/salvar_banco_dados.php">
    <label>Nome:</label>
    <input type="text" id="nomeCarta" name="nomeCarta" required>

    <label>Edição:</label>
    <select name="nomeEdicao">
        <?php include 'php/carregar_edicoes.php'; ?>
    </select>

    <label>Quantidade:</label>
    <input type="number" name="quantidade" value="1">

    <button type="submit">Adicionar</button>
</form>
