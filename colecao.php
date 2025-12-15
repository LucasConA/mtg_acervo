<?php
include "php/listar_cartas.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Coleção - Acervo MTG</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>
<body>

<div id="interface">

<header id="cabecalho">
    <h1>Minha Coleção</h1>
    <nav>
        <a href="/mtg_acervo/" class="botao">Adicionar Carta</a>
    </nav>
</header>

<main>

<?php if (count($cartas) == 0): ?>
    <p><h1>Nenhuma carta cadastrada ainda.</h1></p>
<?php else: ?>

<table id="lista_cartas" border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Edição</th>
            <th>Raridade</th>
            <th>Condição</th>
            <th>Idioma</th>
            <th>Tipo</th>
            <th>Foil</th>
            <th>Valor (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($cartas as $carta): ?>
        <tr>
            <td><?= htmlspecialchars($carta['carta']) ?></td>
            <td><?= $carta['edicao'] ?></td>
            <td><?= $carta['raridade'] ?></td>
            <td><?= $carta['condicao'] ?></td>
            <td><?= $carta['idioma'] ?></td>
            <td><?= $carta['tipo'] ?></td>
            <td><?= $carta['foil'] ? 'Sim' : 'Não' ?></td>
            <td><?= number_format($carta['valor'], 2, ',', '.') ?></td>
            <td>
        </a>
            <a href="/mtg_acervo/editar_carta.php?id=<?= $carta['id'] ?>" class="botao">Editar</a>

            <form action="/mtg_acervo/php/excluir_carta.php"
                      method="post"
                      style="display:inline"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta carta?');">

                    <input type="hidden" name="id" value="<?= $carta['id'] ?>">
                    <button type="submit" class="botao">Excluir
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

</main>

</div>

</body>
</html>
