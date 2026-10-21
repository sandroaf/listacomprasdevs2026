<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS-TI 2026</title>
    <script src="funcoes.js"></script>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS-TI 2026</h1>
        <nav>
            <button type="button" onclick="document.location='incluirlista.php'"><img src="img/add.png" class="icon">Incluir</button>
        </nav>
        <br>
            <?php
            require_once("conexao.php");
            $stmt = $conn->prepare("SELECT * FROM lista");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "<ul>";
                foreach ($stmt as $lista) {
                    echo "<li>" . $lista["codigo"] . " - " . $lista["nome"];
                    echo "<button onclick='incluiritens(".$lista["codigo"].",\"".$lista["nome"]."\")' title='Incluir Itens'><img class='icon' src='img/add.png'></button>";                    
                    echo "<button onclick='alterarlista(".$lista["codigo"].",\"".$lista["nome"]."\")' title='Alterar Lista'><img class='icon' src='img/update.png'></button>";
                    echo "<button onclick='apagarlista(".$lista["codigo"].",\"".$lista["nome"]."\")' title='Ecluir Lista'><img class='icon' src='img/delete.png'></button><br>";
                    //Itens da Lista

                        $stitem = $conn->prepare("SELECT * FROM itens WHERE codigo_lista = :codigo");
                        $stitem->execute(["codigo" => $lista["codigo"]]);
                        if ($stitem->rowCount() > 0) {
                            echo "<h4>Itens: </h4>";
                            echo "<ul>";
                            foreach ($stitem as $item) {
                                echo "<li class='item'>" . $item["codigo"] . " - " . $item["descricao"] . " - " . $item["quantidade"] . " - " . $item["datahora"];                    
                                echo "<button onclick='alteraritem(".$item["codigo"].")' title='Alterar Item'><img class='icon' src='img/update.png'></button>";
                                echo "<button onclick='apagaritem(".$item["codigo"].",\"".$item["descricao"]."\")' title='Ecluir Item'><img class='icon' src='img/delete.png'></button>" . "</li>";
                            }
                            echo "</ul>";
                        }
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo("<p>Não há listas cadastradas</p>");
            }
            ?>
        </ul>
        <footer>
            <p id="msg"><?php if (isset($_GET["msg"])) {
                echo $_GET["msg"];
            }
             ?>
             <script>limpamsg();</script>
            </p>
        </footer>
    </main>
</body>
</html>