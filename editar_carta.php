<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'php/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("ID inválido");
}

// Busca da carta
$sql = "SELECT * FROM cartas WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$carta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$carta) {
    die("Carta não encontrada");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Carta</title>
    <link rel="stylesheet" href="_css/estilo.css">
</head>
<body>

<div id="interface">

<header id="cabecalho">
    <h1>Editar Carta</h1>
    <nav id="menu">
        <ul>
            <li><a href="/mtg_acervo/colecao.php" class="botao">Voltar</a></li>
        </ul>
    </nav>
</header>

<form method="post" action="php/update_carta.php">

    
    <input type="hidden" name="id" value="<?= $carta['id'] ?>">

    <span class="campoTitulo">Nome:</span>
    <input type="text" name="nomeCarta"
           value="<?= htmlspecialchars($carta['nome']) ?>" required><br>

    <span class="campoTitulo">Edição:</span>
    <select name="nomeEdicao" required>
        <?php
        $edicoes = $pdo->query("SELECT * FROM edicoes ORDER BY nome")->fetchAll();
        foreach ($edicoes as $e):
        ?>
            <option value="<?= $e['id'] ?>"
                <?= $e['id'] == $carta['id_edicao'] ? 'selected' : '' ?>>
                <?= $e['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <span class="campoTitulo">Raridade:</span>
    <select name="raridade" required>
        <?php
        $raridades = $pdo->query("SELECT * FROM raridades ORDER BY nome")->fetchAll();
        foreach ($raridades as $r):
        ?>
            <option value="<?= $r['id'] ?>"
                <?= $r['id'] == $carta['id_raridade'] ? 'selected' : '' ?>>
                <?= $r['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <span class="campoTitulo">Condição:</span>
    <select name="condicao">
        <?php
        $condicoes = $pdo->query("SELECT * FROM condicao ORDER BY nome")->fetchAll();
        foreach ($condicoes as $c):
        ?>
            <option value="<?= $c['id'] ?>"
                <?= $c['id'] == $carta['id_condicao'] ? 'selected' : '' ?>>
                <?= $c['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <span class="campoTitulo">Idioma:</span>
    <select name="idioma">
        <?php
        $idiomas = $pdo->query("SELECT * FROM idiomas ORDER BY nome")->fetchAll();
        foreach ($idiomas as $i):
        ?>
            <option value="<?= $i['id'] ?>"
                <?= $i['id'] == $carta['id_idioma'] ? 'selected' : '' ?>>
                <?= $i['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <span class="campoTitulo">Tipo:</span>
    <select name="tipo" required>
        <?php
        $tipos = $pdo->query("SELECT * FROM tipos ORDER BY nome")->fetchAll();
        foreach ($tipos as $t):
        ?>
            <option value="<?= $t['id'] ?>"
                <?= $t['id'] == $carta['id_tipo'] ? 'selected' : '' ?>>
                <?= $t['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <span class="campoTitulo">Foil:</span>
    <input type="radio" name="foil" value="normal"
        <?= !$carta['foil'] ? 'checked' : '' ?>> Normal

    <input type="radio" name="foil" value="foil"
        <?= $carta['foil'] ? 'checked' : '' ?>> Foil<br>

    <span class="campoTitulo">Valor R$:</span>
    <input type="number" name="valorCarta" step="0.01" min="0"
           value="<?= $carta['valor'] ?>"><br>

    <button type="submit" class="botao">Salvar Alterações</button>

</form>

</div>

</body>
</html>
