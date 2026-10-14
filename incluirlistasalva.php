<?php
    require_once("conexao.php");
    if (isset($_POST["fnome"])) {
        try {
            $parnome = ['nome' => $_POST["fnome"]];
            $stmt = $conn->prepare("INSERT INTO lista (nome) VALUE (:nome)");
            $stmt->execute($parnome);
            header("Location: index.php");

        } catch (PDOException $e) {
            echo "ERRO! Não foi possível inclir a lista: ".$e->getMessage();
        }

    } else {
        header("Location: incluirlista.php");
    }
?>