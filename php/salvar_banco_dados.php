<?php
require "conexao.php"; 

// ===========================
// 1. Validar campos obrigatórios
// ===========================
$camposObrigatorios = ['nomeCarta', 'nomeEdicao', 'raridade', 'condicao', 'idioma', 'tipo', 'valorCarta'];

foreach ($camposObrigatorios as $campo) {
    if (empty($_POST[$campo])) {
        die("Erro: O campo <strong>$campo</strong> não foi preenchido!");
    }
}

// ===========================
// 2. Receber dados do formulário
// ===========================
$nome = $_POST['nomeCarta'];
$edicao = $_POST['nomeEdicao'];
$raridade = $_POST['raridade'];
$condicao = $_POST['condicao'];
$idioma = $_POST['idioma'];
$tipo = $_POST['tipo'];
$valor = $_POST['valorCarta'];

// proteger Foil caso o user não selecione nada
$foil = isset($_POST['foil']) && $_POST['foil'] === "foil" ? 1 : 0;

// ===========================
// 3. Inserir no banco
// ===========================
try {
    $sql = $pdo->prepare("
        INSERT INTO cartas 
        (nome, edicao_id, raridade_id, condicao_id, idioma_id, tipo_id, foil, valor)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $sql->execute([
        $nome, $edicao, $raridade, $condicao, $idioma, $tipo, $foil, $valor
    ]);

    echo "<h2>Carta cadastrada com sucesso!</h2>";
    echo "<a href='../index.html'>Voltar</a>";

} catch (PDOException $erro) {
    die("Erro ao salvar no banco: " . $erro->getMessage());
}
?>
