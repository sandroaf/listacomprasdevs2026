function apagarlista(codigo, nome) {
    if (window.confirm("Confirma exclusão da lista: " + codigo + " - " + nome + " ?")) {
        window.location = "excluirlista.php?confirma=S&codigo=" + codigo + "&nome=" + nome;
    }
}

function alterarlista(codigo, nome) {
    window.location = "alterarlista.php?codigo=" + codigo + "&nome=" + nome;
}



function limpamsg() {
    setInterval( function () { 
        msg = document.getElementById("msg");
        msg.innerHTML = "";
     }, 4000)
}
