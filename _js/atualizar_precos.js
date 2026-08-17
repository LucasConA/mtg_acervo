document.addEventListener('DOMContentLoaded', function () {
    const selecionarTodas = document.getElementById('selecionar_todas');
    const checkboxes = document.querySelectorAll('.carta-checkbox');
    const btnAtualizarPrecos = document.getElementById('btn-atualizar-precos');
    
    const modalLoading = document.getElementById('modal-loading-scraper');
    const loadingText = document.getElementById('loading-scraper-text');
    
    const modalPreview = document.getElementById('modal-preview-scraper');
    const previewTbody = document.getElementById('preview-scraper-tbody');
    const unmatchedSection = document.getElementById('preview-unmatched-section');
    const unmatchedList = document.getElementById('preview-unmatched-list');
    const btnConfirmar = document.getElementById('btn-confirmar-scraper');

    const selectLoja = document.getElementById('select-loja');

    let pendingUpdates = [];

    // Enable/Disable main button based on selection
    function updateButtonState() {
        // Always enabled to allow showing popup alert on click
    }

    if (selecionarTodas) {
        selecionarTodas.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                cb.checked = selecionarTodas.checked;
            });
            updateButtonState();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            if (selecionarTodas && !this.checked) {
                selecionarTodas.checked = false;
            }
            updateButtonState();
        });
    });

    if (btnAtualizarPrecos) {
        btnAtualizarPrecos.addEventListener('click', async function () {
            const checkedBoxes = document.querySelectorAll('.carta-checkbox:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            const total = ids.length;

            if (total === 0) {
                alert("Por favor, selecione pelo menos uma carta para atualizar os preços.");
                return;
            }

            // Reset and Show Loading Modal
            modalLoading.style.display = 'flex';
            loadingText.textContent = `Calculando preço (1 de ${total})...`;

            const updates = [];
            const unmatched = [];

            // Fetch one card at a time to prevent PHP execution timeouts and show live progress
            for (let i = 0; i < total; i++) {
                loadingText.textContent = `Calculando preço (${i + 1} de ${total})...`;
                
                try {
                    const response = await fetch(`${BASE_URL}/atualizar_valores.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            acao: 'preview',
                            ids: [ids[i]]
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        if (result.updates && result.updates.length > 0) {
                            updates.push(...result.updates);
                        }
                        if (result.unmatched && result.unmatched.length > 0) {
                            unmatched.push(...result.unmatched);
                        }
                    } else {
                        // Treat as error/unmatched
                        unmatched.push({
                            id: ids[i],
                            nome: `ID #${ids[i]}`,
                            edicao: 'Erro',
                            condicao: 'Erro',
                            foil: 'N/A',
                            preco_atual: 0.0,
                            error: result.error || 'Erro desconhecido'
                        });
                    }
                } catch (err) {
                    unmatched.push({
                        id: ids[i],
                        nome: `ID #${ids[i]}`,
                        edicao: 'Erro de Rede',
                        condicao: 'Erro',
                        foil: 'N/A',
                        preco_atual: 0.0,
                        error: err.message
                    });
                }
            }

            // Hide Loading Modal
            modalLoading.style.display = 'none';

            // Show Preview Modal
            pendingUpdates = updates;
            renderPreview(updates, unmatched);
        });
    }

    function renderPreview(updates, unmatched) {
        previewTbody.innerHTML = '';
        unmatchedList.innerHTML = '';

        if (updates.length === 0) {
            previewTbody.innerHTML = `
                <tr>
                    <td colspan="8" style="padding: 15px; text-align: center; color: #aaa;">
                        Nenhuma alteração de preço correspondente encontrada nas lojas.
                    </td>
                </tr>
            `;
            btnConfirmar.disabled = true;
        } else {
            btnConfirmar.disabled = false;
            updates.forEach(up => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #444';
                
                const formatBRL = (val) => {
                    return Number(val).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                };

                let precoNovoStyle = 'color: #d4af37; font-weight: bold;';
                if (up.preco_novo > up.preco_atual) {
                    precoNovoStyle = 'color: #28a745; font-weight: bold;'; // green for increase
                } else if (up.preco_novo < up.preco_atual) {
                    precoNovoStyle = 'color: #dc3545; font-weight: bold;'; // red for decrease
                }

                // Check condition mismatch
                const isMismatch = up.condicao_original.toLowerCase() !== up.condicao_encontrada.toLowerCase();
                const condicaoEncontradaDisplay = isMismatch 
                    ? `<span style="color: #ff9f43; font-weight: bold;">${escapeHtml(up.condicao_encontrada)} *</span>`
                    : `<span>${escapeHtml(up.condicao_encontrada)}</span>`;

                tr.innerHTML = `
                    <td style="padding: 10px;">${escapeHtml(up.nome)}</td>
                    <td style="padding: 10px;">${escapeHtml(up.edicao)}</td>
                    <td style="padding: 10px; text-align: center;">${up.foil}</td>
                    <td style="padding: 10px; text-align: center; font-size: 13px; color: #d4af37;">${escapeHtml(up.loja_encontrada)}</td>
                    <td style="padding: 10px; text-align: center; color: #aaa;">${escapeHtml(up.condicao_original)}</td>
                    <td style="padding: 10px; text-align: center;">${condicaoEncontradaDisplay}</td>
                    <td style="padding: 10px; text-align: right; color: #aaa;">${formatBRL(up.preco_atual)}</td>
                    <td style="padding: 10px; text-align: right; ${precoNovoStyle}">${formatBRL(up.preco_novo)}</td>
                `;
                previewTbody.appendChild(tr);
            });
        }

        if (unmatched.length > 0) {
            unmatchedSection.style.display = 'block';
            unmatched.forEach(un => {
                const li = document.createElement('li');
                li.style.marginBottom = '4px';
                li.textContent = `${un.nome} [${un.edicao || 'Sem Edição'}] (${un.condicao || 'Sem Condição'}${un.foil === 'Sim' ? ' Foil' : ''}) - Mantido R$ ${Number(un.preco_atual).toFixed(2).replace('.', ',')}`;
                unmatchedList.appendChild(li);
            });
        } else {
            unmatchedSection.style.display = 'none';
        }

        modalPreview.style.display = 'flex';
    }

    if (btnConfirmar) {
        btnConfirmar.addEventListener('click', async function () {
            if (pendingUpdates.length === 0) return;

            btnConfirmar.disabled = true;
            btnConfirmar.textContent = 'Gravando...';

            try {
                const response = await fetch(`${BASE_URL}/atualizar_valores.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        acao: 'confirmar',
                        updates: pendingUpdates.map(up => ({ id: up.id, valor: up.preco_novo }))
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('Valores de cartas atualizados com sucesso!');
                    window.location.reload();
                } else {
                    alert('Erro ao gravar atualizações: ' + (result.error || 'Erro desconhecido'));
                    btnConfirmar.disabled = false;
                    btnConfirmar.textContent = 'Confirmar e Aplicar';
                }
            } catch (err) {
                alert('Erro de rede ao gravar atualizações: ' + err.message);
                btnConfirmar.disabled = false;
                btnConfirmar.textContent = 'Confirmar e Aplicar';
            }
        });
    }

    function escapeHtml(string) {
        return String(string).replace(/[&<>"']/g, function (s) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[s];
        });
    }

    // --- CLIENT-SIDE SEARCH BAR FOR COLLECTION ---
    const inputBusca = document.getElementById('buscar-carta-colecao');
    const btnLimpar = document.getElementById('btn-limpar-busca');
    const listAutocomplete = document.getElementById('autocomplete-colecao');
    
    if (inputBusca && listAutocomplete) {
        const rows = document.querySelectorAll('#lista_cartas tbody tr');
        const hasCheckbox = document.querySelector('.carta-checkbox') !== null;
        const nameColumnIndex = hasCheckbox ? 2 : 1;

        // Get unique list of card names in the table
        const cardNames = Array.from(new Set(Array.from(rows).map(row => {
            const cell = row.querySelector(`td:nth-child(${nameColumnIndex})`);
            return cell ? cell.textContent.trim() : '';
        }))).filter(name => name !== '');

        function filtrarTabela(termo) {
            rows.forEach(row => {
                const cell = row.querySelector(`td:nth-child(${nameColumnIndex})`);
                if (!cell) return;
                const cardName = cell.textContent.trim().toLowerCase();
                
                if (termo === '' || cardName === termo.toLowerCase()) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            if (termo !== '') {
                if (btnLimpar) btnLimpar.style.display = 'inline-block';
            } else {
                if (btnLimpar) btnLimpar.style.display = 'none';
            }
        }

        inputBusca.addEventListener('input', function () {
            const val = this.value.trim().toLowerCase();
            listAutocomplete.innerHTML = '';

            if (val.length < 1) {
                listAutocomplete.style.display = 'none';
                filtrarTabela('');
                return;
            }

            const matches = cardNames.filter(name => name.toLowerCase().includes(val));

            if (matches.length === 0) {
                listAutocomplete.style.display = 'none';
                return;
            }

            matches.forEach(match => {
                const div = document.createElement('div');
                div.className = 'autocomplete-item';
                div.style.padding = '8px 12px';
                div.style.cursor = 'pointer';
                div.style.borderBottom = '1px solid #333';
                div.innerHTML = `<strong>${escapeHtml(match)}</strong>`;
                
                div.addEventListener('click', function () {
                    inputBusca.value = match;
                    listAutocomplete.innerHTML = '';
                    listAutocomplete.style.display = 'none';
                    filtrarTabela(match);
                });
                listAutocomplete.appendChild(div);
            });

            listAutocomplete.style.display = 'block';
        });

        // Hide list when clicking outside
        document.addEventListener('click', function (e) {
            if (e.target !== inputBusca && !listAutocomplete.contains(e.target)) {
                listAutocomplete.innerHTML = '';
                listAutocomplete.style.display = 'none';
            }
        });

        if (btnLimpar) {
            btnLimpar.addEventListener('click', function () {
                inputBusca.value = '';
                listAutocomplete.innerHTML = '';
                listAutocomplete.style.display = 'none';
                filtrarTabela('');
            });
        }
    }
});
