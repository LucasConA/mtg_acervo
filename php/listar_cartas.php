<?php
require "conexao.php";

/*
  Este arquivo é responsável APENAS por:
  - Buscar as cartas no banco
  - Resolver os JOINs
  - Entregar os dados prontos em $cartas
*/

// Define ordenação padrão
$orderBy = "c.nome ASC";

if (!empty($_GET['ordem'])) {
    switch ($_GET['ordem']) {
        case 'nome_asc':
            $orderBy = "c.nome ASC";
            break;

        case 'nome_desc':
            $orderBy = "c.nome DESC";
            break;

        case 'valor_asc':
            $orderBy = "c.valor ASC";
            break;

        case 'valor_desc':
            $orderBy = "c.valor DESC";
            break;
    }
}

$sql = $pdo->query("
    SELECT 
        c.id,
        c.nome AS carta,
        COALESCE(e.nome_pt, e.nome_en) AS edicao,
        r.nome AS raridade,
        co.nome AS condicao,
        i.nome AS idioma,
        t.nome AS tipo,
        c.foil,
        c.quantidade,
        c.valor
    FROM cartas c
    INNER JOIN edicoes   e  ON c.id_edicao   = e.id
    INNER JOIN raridades r  ON c.id_raridade = r.id
    INNER JOIN condicao  co ON c.id_condicao = co.id
    INNER JOIN idiomas   i  ON c.id_idioma   = i.id
    INNER JOIN tipos     t  ON c.id_tipo     = t.id
    ORDER BY $orderBy
");

$cartas = $sql->fetchAll(PDO::FETCH_ASSOC);
