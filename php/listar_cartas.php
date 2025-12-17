<?php
require "conexao.php";

/*
  Este arquivo é responsável APENAS por:
  - Buscar as cartas no banco
  - Resolver os JOINs
  - Entregar os dados prontos em $cartas
*/

$sql = $pdo->query("
    SELECT 
        c.id,
        c.nome AS carta,
        e.nome AS edicao,
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
    ORDER BY c.nome ASC
");

$cartas = $sql->fetchAll(PDO::FETCH_ASSOC);
