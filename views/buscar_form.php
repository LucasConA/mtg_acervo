<section id="busca-cartas">

    <hr>

    <h2>Buscar cartas na coleção</h2>

    <form method="get" action="#busca-cartas">

        <label for="busca_nome">Nome:</label>
        <input
            type="text"
            id="busca_nome"
            name="busca_nome"
            value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>"
        >

        <label for="busca_edicao">Edição:</label>
        <select name="busca_edicao" id="busca_edicao">
            <option value="">Todas</option>
            <?php include 'php/carregar_edicoes.php'; ?>
        </select>

        <label for="busca_raridade">Raridade:</label>
        <select name="busca_raridade" id="busca_raridade">
            <option value="">Todas</option>
            <?php include 'php/carregar_raridades.php'; ?>
        </select>

        <label for="busca_tipo">Tipo:</label>
        <select name="busca_tipo" id="busca_tipo">
            <option value="">Todos</option>
            <?php include 'php/carregar_tipos.php'; ?>
        </select>

        <button type="submit" class="botao">Buscar</button>
    </form>

    <?php if (!empty($cartas)): ?>

        <hr>
        <h3>Resultado da busca</h3>

        <table border="1" cellpadding="6">
            <thead>
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
            </thead>

            <tbody>
                <?php foreach ($cartas as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nome']) ?></td>
                        <td><?= htmlspecialchars($c['edicao']) ?></td>
                        <td><?= htmlspecialchars($c['raridade']) ?></td>
                        <td><?= htmlspecialchars($c['condicao']) ?></td>
                        <td><?= htmlspecialchars($c['idioma']) ?></td>
                        <td><?= htmlspecialchars($c['tipo']) ?></td>
                        <td><?= $c['foil'] ? 'Foil' : 'Normal' ?></td>
                        <td>R$ <?= number_format($c['valor'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

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

    <?php elseif (array_filter($filtros)): ?>

        <p><strong>Nenhuma carta encontrada.</strong></p>

    <?php endif; ?>

</section>
