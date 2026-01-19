<section id="adicionar-cartas">

    <h2>Adicionar à coleção</h2>

    <form method="post" action="<?= BASE_URL ?>/php/salvar_banco_dados.php">

        <span class="campoTitulo">Nome:</span>
        <input
            type="text"
            id="nomeCarta"
            name="nomeCarta"
            data-autocomplete="carta"
            required
        >
        <div id="autocomplete-list"></div>
        <br>

        <span class="campoTitulo">Edição:</span>
        <select name="nomeEdicao" required>
            <option value="">Selecione</option>
            <?php include BASE_PATH . '/php/carregar_edicoes.php'; ?>
        </select><br>

        <span class="campoTitulo">Raridade:</span>
        <select name="raridade" required>
            <?php include BASE_PATH . '/php/carregar_raridades.php'; ?>
        </select><br>

        <span class="campoTitulo">Condição:</span>
        <select name="condicao" required>
            <?php include BASE_PATH . '/php/carregar_condicoes.php'; ?>
        </select><br>

        <span class="campoTitulo">Idioma:</span>
        <select name="idioma" required>
            <?php include BASE_PATH . '/php/carregar_idiomas.php'; ?>
        </select><br>

        <span class="campoTitulo">Tipo:</span>
        <select name="tipo" required>
            <?php include BASE_PATH . '/php/carregar_tipos.php'; ?>
        </select><br>

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
        <input type="number" name="quantidade" min="1" value="1"><br>

        <span class="campoTitulo">Valor R$:</span>
        <input type="number" name="valorCarta" step="0.01" min="0"><br>

        <button type="submit" class="botao">
            Adicionar carta
        </button>

    </form>

</section>
