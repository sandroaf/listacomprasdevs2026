<?php
require_once __DIR__ . '/funcoes.php';
// Buscamos o registro antes do HTML, permitindo redirecionar em caso de erro.
try {
    $codigo = validarCodigo($_GET['codigo'] ?? null);
    require __DIR__ . '/conexao.php';
    $item = buscarItem($conn, $codigo);
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
    <title>Lista de Compras - Alterar Item</title>
</head>
<body>
    <main>
        <h1>Alterar Item</h1>
        <form action="alteraritemsalva.php" method="post" class="cadastro">
            <?php campoCsrf(); // Envia o token da sessão junto com os dados. ?>
            <p>Lista: <strong><?= escapar($item['codigo_lista']) ?> - <?= escapar($item['nome']) ?></strong></p>
            <label for="fdescricao">Descrição</label>
            <input id="fdescricao" type="text" name="fdescricao" maxlength="150" required value="<?= escapar($item['descricao']) ?>">
            <label for="fquantidade">Quantidade</label>
            <!-- O servidor repete a validação e rejeita valores fora do DECIMAL(10,2). -->
            <input id="fquantidade" type="number" name="fquantidade" min="0.01" max="99999999.99" step="0.01" value="<?= escapar($item['quantidade']) ?>" required>
            <input type="hidden" name="fcodigo" value="<?= escapar($item['codigo']) ?>">
            <div class="acoes">
                <button type="submit"><img class="icon" src="img/save.png" alt="">Salvar</button>
                <a class="botao" href="index.php"><img class="icon" src="img/cancel.png" alt="">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
