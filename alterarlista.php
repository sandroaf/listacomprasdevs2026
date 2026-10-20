<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS-TI 2026 - Alterar Lista</title>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS-TI 2026 - Alterar Lista</h1>
        <?php 
            if (isset($_GET["codigo"]) && isset($_GET["nome"])) {
                $codigo = $_GET["codigo"];
                $nome = $_GET["nome"];
            } else {
                $msg = htmlspecialchars("Erro ao altarar lista!");
                header("Location index.php?msg=$msg");
            }
        ?>
        <form action="alterarlistasalva.php" method="post">
            <input type="hidden" name="fcodigo" value="<?= $codigo ?>"> 
            <label for="fnome">Nome da Lista: </label>
            <input type="text" name="fnome" value="<?= $nome ?>" required>
            <br><br>
            <button type="submit"><img class="icon" src="img/save.png"> Salvar</button>&nbsp;
            <button type="reset" onclick="document.location='index.php'"><img class="icon" src="img/cancel.png">Cancelar</button>
        </form>
    </main>
</body>

</html>