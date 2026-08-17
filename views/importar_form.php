<?php require_once __DIR__ . '/../config.php'; ?>

<h2>Importar cartas via Excel</h2> 

<a href="<?= BASE_URL ?>/assets/modelos/modelo_importacao_cartas.xlsx" class="botao" download>
    Baixar modelo de Excel
</a>
<small style="color:#aaa;">
    Preencha o arquivo seguindo exatamente o formato do modelo.
</small>

<form action="<?= BASE_URL ?>/php/importar_preview.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo" required>
    <button type="submit" class="botao">Importar</button>
</form>
