<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS-TI 2026 - Alterar Item</title>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS-TI 2026 - Alterar Item</h1>
        <form action="alteraritemsalva.php" method="post">
            <?php
                require_once("conexao.php");
                $stitem = $conn->prepare("SELECT itens.codigo, itens.descricao, itens.quantidade, itens.codigo_lista, lista.nome FROM itens, lista WHERE itens.codigo = :codigo AND lista.codigo = itens.codigo_lista;");
                $stitem->execute(["codigo" => $_GET["codigo"]]);
                $item = $stitem->fetch(PDO::FETCH_ASSOC);  
            ?>

            <p>Lista: <strong><?= $item["codigo_lista"]." - ".$item["nome"] ?></strong></p>
            <label for="fdescricao">Descrição: </label>
            <input type="text" name="fdescricao" required value="<?= $item["descricao"] ?>"><br>
            <label for="fquantidade">Quantidade: </label>
            <input type="number" step="0.01" name="fquantidade" value="<?= $item["quantidade"] ?>">
            <input type="hidden" name="fcodigo" value="<?= $item["codigo"] ?>"> 
            <br><br>
            <button type="submit"><img class="icon" src="img/save.png"> Salvar</button>&nbsp;
            <button type="reset" onclick="document.location='index.php'"><img class="icon" src="img/cancel.png">Cancelar</button>
        </form>
    </main>
</body>

</html>