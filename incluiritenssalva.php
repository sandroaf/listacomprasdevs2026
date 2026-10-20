<?php
    require_once("conexao.php");
    if (isset($_POST["fdescricao"])) {
        try {
            $par = ['descricao' => $_POST["fdescricao"]
                    ,'quantidade' => $_POST["fquantidade"]
                    ,'codigo_lista' => $_POST["fcodigolista"]];
            $stmt = $conn->prepare("INSERT INTO itens (descricao, quantidade, codigo_lista) VALUE (:descricao, :quantidade, :codigo_lista)");
            $stmt->execute($par);
            $msg=htmlspecialchars("Item incluído com sucesso!");
            header("Location: index.php?msg=$msg");
        } catch (PDOException $e) {
            $msg = htmlspecialchars("ERRO! Não foi possível inclir itens: ".$e->getMessage());
            header("Location: index.php?msg=$msg");
        }
    } else {
        $msg= htmlspecialchars("Erro ao incluir item");
        header("Location: index.php?msg=$msg");
    }
?>