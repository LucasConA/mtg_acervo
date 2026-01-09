const input = document.getElementById('nomeCarta');
const lista = document.getElementById('autocomplete-list');
let timeout = null;

if (input) {
    input.addEventListener('input', () => {
        clearTimeout(timeout);
        const termo = input.value.trim();
        lista.innerHTML = '';

        if (termo.length < 2) return;

        timeout = setTimeout(() => {
            fetch('php/autocomplete_scryfall.php?q=' + encodeURIComponent(termo))
                .then(res => res.json())
                .then(json => {
                    if (!json.data) return;

                    json.data.forEach(nome => {
                        const item = document.createElement('div');
                        item.textContent = nome;
                        item.onclick = () => {
                            input.value = nome;
                            lista.innerHTML = '';
                            buscarNomePTBR(nome);
                        };
                        lista.appendChild(item);
                    });
                });
        }, 300);
    });
}
