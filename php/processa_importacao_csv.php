<?php
require 'conexao.php';

if(!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== 0){
    die("Erro: Nenhum arquivo enviado.");
}

$arquivo = $_FILES['arquivo']['tmp_name'];

if (($handle = fopen($arquivo, "r")) !== FALSE) {

    $primeiraLinha = true;

    while (($dados = fgetcsv($handle, 1000, ";")) !== FALSE) {
        
        if ($primeiraLinha) { $primeiraLinha = false; continue; }

        [$nome, $ed, $rar, $cond, $idioma, $tipo, $foil, $qtd, $valor] = $dados;

        if(!$nome) continue;

        $fk = [
            'edicao'   => buscaId($pdo, 'edicoes', $ed),
            'raridade' => buscaId($pdo, 'raridades', $rar),
            'condicao' => buscaId($pdo, 'condicao', $cond),
            'idioma'   => buscaId($pdo, 'idiomas', $idioma),
            'tipo'     => buscaId($pdo, 'tipos', $tipo)
        ];

        foreach ($fk as $campo => $id) {
            if($id === null){
                echo "⚠️ Ignorada: $nome — $campo não existe no banco.<br>";
                continue 2;
            }
        }

        $foil = ($foil === "foil") ? 1 : 0;
        $qtd = (int)$qtd;
        $valor = (float)$valor;

        // EVITA DUPLICATAS
        $check = $pdo->prepare("SELECT id FROM cartas 
            WHERE nome = ? AND id_edicao = ? AND id_idioma = ? AND id_tipo = ? AND foil = ?");
        $check->execute([$nome, $fk['edicao'], $fk['idioma'], $fk['tipo'], $foil]);

        if($check->fetch()){
            echo "🔁 Já existe: $nome (ignorada)<br>";
            continue;
        }

        // INSERE
        $ins = $pdo->prepare("INSERT INTO cartas 
            (nome, id_edicao, id_raridade, id_condicao, id_idioma, id_tipo, foil, quantidade, valor)
            VALUES (?,?,?,?,?,?,?,?,?)");
        $ins->execute([$nome, ...array_values($fk), $foil, $qtd, $valor]);

        echo "✔️ Importada: $nome<br>";
    }

    fclose($handle);
}

function buscaId($pdo, $tabela, $nome){
    $q = $pdo->prepare("SELECT id FROM $tabela WHERE nome = ?");
    $q->execute([$nome]);
    return $q->fetchColumn() ?: null;
}

echo "<hr><strong>Importação concluída!</strong> 🚀";
