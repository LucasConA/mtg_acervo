function buscarNomePTBR(nome) {
    fetch('php/buscar_ptbr_scryfall.php?nome=' + encodeURIComponent(nome))
        .then(res => res.json())
        .then(dados => {
            if (dados.nome) {
                document.getElementById('nomeCarta').value = dados.nome;
            }
        });
}
