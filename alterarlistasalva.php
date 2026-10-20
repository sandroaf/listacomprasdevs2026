<?php
    require_once("conexao.php");
    if (isset($_POST["fcodigo"]) && isset($_POST["fnome"])) {
        try {
            $par = ['nome' => $_POST["fnome"], 'codigo'=> $_POST["fcodigo"]];
            $stmt = $conn->prepare("UPDATE lista SET nome = :nome WHERE codigo = :codigo");
            $msg = htmlspecialchars("Lista alterda com sucesso! ");
            $stmt->execute($par);
            header("Location: index.php?msg=$msg");
        } catch (PDOException $e) {
            $msg = htmlspecialchars("ERRO! Não foi possível alterar a lista: ".$e->getMessage());
            header("Location: index.php?msg=$msg");
        }
    } else {
        $msg = htmlspecialchars("ERRO! Não foi possível alterar a lista");
        header("Location: index.php?msg=$msg");
    }
?>