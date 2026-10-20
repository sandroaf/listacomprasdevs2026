<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS-TI 2026 - Novo Item</title>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS-TI 2026 - Novo Item</h1>
        <form action="incluiritenssalva.php" method="post">
            <p>Lista: <strong><?= $_GET["codigo"]." - ".$_GET["nome"] ?></strong></p>
            <label for="fdescricao">Descrição: </label>
            <input type="text" name="fdescricao" required><br>
            <label for="fquantidade">Quantidade: </label>
            <input type="number" step="0.01" value="1" name="fquantidade">
            <input type="hidden" name="fcodigolista" value="<?= $_GET["codigo"] ?>"> 
            <br><br>
            <button type="submit"><img class="icon" src="img/save.png"> Salvar</button>&nbsp;
            <button type="reset" onclick="document.location='index.php'"><img class="icon" src="img/cancel.png">Cancelar</button>
        </form>
    </main>
</body>

</html>