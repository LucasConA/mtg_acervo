<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="_css/estilo.css">
    <title>Acervo MTG</title>
</head>

<body>
<div id="interface">
    <header id="cabecalho"> 
       <h1> Acervo MTG</h1> 
       <nav id="menu">
            <ul>
                <li><a href="/colecao.php" class="botao">Minha Coleção</a></li>

            </ul>
       </nav>
    </header>  
    <h1>Minha Coleção</h1> 
    <form method="post" action="salvar_banco_dados.php">
    Nome: <input type="text" name="nomeCarta" required><br>

    Edição:
    <select name="nomeEdicao">
        <option value="">Selecione</option>
        <?php include 'php/carregar_edicoes.php'; ?>
    </select><br>

    Raridade:
    <select name="raridade" required>
        <?php include 'php/carregar_raridades.php'; ?>
    </select><br>

    Condição:
    <select name="condicao">
        <?php include 'php/carregar_condicoes.php'; ?>
    </select><br>

    Idioma:
    <select name="idioma">
        <?php include 'php/carregar_idiomas.php'; ?>
    </select><br>

    Tipo:
    <select name="tipo" required>
        <?php include 'php/carregar_tipos.php'; ?>
    </select><br>

    Foil:
    <input type="radio" name="foil" value="normal" checked> Normal
    <input type="radio" name="foil" value="foil"> Foil<br>

    Valor R$: <input type="number" name="valorCarta" step="0.01" min="0"><br>

    <button type="submit">Adicionar carta</button>
</form>
 

    <footer id="rodape">

    </footer>
</div>
</body>
</html>