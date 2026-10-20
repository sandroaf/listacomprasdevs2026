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
                    echo "<button onclick='alterarlista(".$lista["codigo"].",\"".$lista["nome"]."\")'><img class='icon' src='img/update.png'></button>";
                    echo "<button onclick='apagarlista(".$lista["codigo"].",\"".$lista["nome"]."\")'><img class='icon' src='img/delete.png'></button>" . "</li>";

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