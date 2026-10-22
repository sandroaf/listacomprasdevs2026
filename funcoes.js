// defer garante que os elementos HTML já existam quando este script executar.
function limpamsg() {
    // A mensagem é apagada uma única vez, depois de cinco segundos.
    setTimeout(() => {
        const msg = document.getElementById('msg');
        if (msg) msg.textContent = '';
    }, 5000);
}

// Os textos ficam em atributos data, sem concatenar dados em código JavaScript.
for (const formulario of document.querySelectorAll('form[data-confirmar]')) {
    formulario.addEventListener('submit', (evento) => {
        if (!window.confirm(formulario.dataset.confirmar)) {
            evento.preventDefault(); // Cancelar não envia a exclusão ao servidor.
        }
    });
}

limpamsg();
