document.addEventListener('DOMContentLoaded', () => {

    const inputs = document.querySelectorAll('[data-autocomplete="carta"]');

    if (!inputs.length) {
        console.warn('Autocomplete: nenhum input encontrado');
        return;
    }

    inputs.forEach(input => {

        const lista = input.nextElementSibling;
        let timeout = null;

        if (!lista) {
            console.warn('Autocomplete: lista não encontrada para', input);
            return;
        }

        input.addEventListener('input', function () {
            clearTimeout(timeout);

            const termo = this.value.trim();
            lista.innerHTML = '';

            if (termo.length < 2) return;

            timeout = setTimeout(() => {
                fetch('php/autocomplete_scryfall.php?q=' + encodeURIComponent(termo))
                    .then(res => res.json())
                    .then(json => {
                        if (!json || !json.data) return;

                        json.data.forEach(nome => {
                            const item = document.createElement('div');
                            item.className = 'autocomplete-item';
                            item.textContent = nome;

                            item.addEventListener('click', () => {
                                input.value = nome;
                                lista.innerHTML = '';
                            });

                            lista.appendChild(item);
                        });
                    })
                    .catch(err => console.error('Erro autocomplete:', err));
            }, 300);
        });

        document.addEventListener('click', e => {
            if (e.target !== input) {
                lista.innerHTML = '';
            }
        });
    });

});
