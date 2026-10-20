<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS-TI 2026 - Nova Lista</title>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS-TI 2026 - Nova Lista</h1>
        <form action="incluirlistasalva.php" method="post">
            <label for="fnome">Nome da Lista: </label>
            <input type="text" name="fnome" required>
            <br><br>
            <button type="submit"><img class="icon" src="img/save.png"> Salvar</button>&nbsp;
            <button type="reset" onclick="document.location='index.php'"><img class="icon" src="img/cancel.png">Cancelar</button>
        </form>
    </main>
</body>

</html>