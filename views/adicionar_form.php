<h1>Adicionar à Coleção</h1>

<form method="post" action="php/salvar_banco_dados.php" autocomplete="off">

    <span class="campoTitulo">Nome:</span>
    <input type="text"
           id="nomeCarta"
           name="nomeCarta"
           required>

    <div id="autocomplete-list"></div>

    <span class="campoTitulo">Edição:</span>
    <select name="nomeEdicao" required>
        <option value="">Selecione</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select>

    <span class="campoTitulo">Raridade:</span>
    <select name="raridade" required>
        <?php include 'php/carregar_opcoes.php?tabela=raridades'; ?>
    </select>

    <span class="campoTitulo">Condição:</span>
    <select name="condicao">
        <?php include 'php/carregar_opcoes.php?tabela=condicao'; ?>
    </select>

    <span class="campoTitulo">Idioma:</span>
    <select name="idioma">
        <?php include 'php/carregar_opcoes.php?tabela=idiomas'; ?>
    </select>

    <span class="campoTitulo">Tipo:</span>
    <select name="tipo" required>
        <?php include 'php/carregar_opcoes.php?tabela=tipos'; ?>
    </select>

    <span class="campoTitulo">Foil:</span>
    <div class="radio-grupo">
        <label>
            <input type="radio" name="foil" value="0" checked>
            Normal
        </label>
        <label>
            <input type="radio" name="foil" value="1">
            Foil
        </label>
    </div>

    <span class="campoTitulo">Quantidade:</span>
    <input type="number" name="quantidade" min="1" value="1">

    <span class="campoTitulo">Valor (R$):</span>
    <input type="number" name="valorCarta" step="0.01" min="0">

    <button type="submit" class="botao">Adicionar carta</button>
</form>
