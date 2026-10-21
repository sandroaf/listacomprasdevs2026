<?php
    require_once("conexao.php");
    if (isset($_POST["fdescricao"])) {
        try {
            $par = ['descricao' => $_POST["fdescricao"]
                    ,'quantidade' => $_POST["fquantidade"]
                    ,'codigo' => $_POST["fcodigo"]];
            $stmt = $conn->prepare("UPDATE itens SET descricao = :descricao, quantidade = :quantidade, datahora = CURRENT_TIMESTAMP WHERE codigo = :codigo");
            $stmt->execute($par);
            $msg=htmlspecialchars("Item alterado com sucesso!");
            header("Location: index.php?msg=$msg");
        } catch (PDOException $e) {
            $msg = htmlspecialchars("ERRO! Não foi possível alterar item: ".$e->getMessage());
            header("Location: index.php?msg=$msg");
        }
    } else {
        $msg= htmlspecialchars("Erro ao alterar item");
        header("Location: index.php?msg=$msg");
    }
?>