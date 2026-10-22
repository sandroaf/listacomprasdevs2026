<?php
require_once __DIR__ . '/funcoes.php';
// Buscamos o registro antes do HTML, permitindo redirecionar em caso de erro.
try {
    $codigo = validarCodigo($_GET['codigo'] ?? null);
    require __DIR__ . '/conexao.php';
    $lista = buscarLista($conn, $codigo);
} catch (Throwable $e) {
    tratarErro($e);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - Alterar Lista</title>
</head>
<body>
    <main>
        <h1>Alterar Lista</h1>
        <form action="alterarlistasalva.php" method="post" class="cadastro">
            <?php campoCsrf(); // Envia o token da sessão junto com os dados. ?>
            <input type="hidden" name="fcodigo" value="<?= escapar($lista['codigo']) ?>">
            <!-- for e id associam o rótulo ao campo; name define a chave enviada ao PHP. -->
            <label for="fnome">Nome da lista</label>
            <input id="fnome" type="text" name="fnome" maxlength="100" required value="<?= escapar($lista['nome']) ?>">
            <div class="acoes">
                <button type="submit"><img class="icon" src="img/save.png" alt="">Salvar</button>
                <a class="botao" href="index.php"><img class="icon" src="img/cancel.png" alt="">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
