
function fecharModal() {
    const modal = document.getElementById('modal-feedback');
    if (modal) modal.remove();

    const url = new URL(window.location);
    url.searchParams.delete('sucesso');
    url.searchParams.delete('erro');
    window.history.replaceState({}, document.title, url);
}
