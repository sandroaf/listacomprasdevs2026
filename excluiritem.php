<?php 
   if (isset($_GET["confirma"])
    && isset($_GET["descricao"])  
    && isset($_GET["codigo"])) {
      require_once("conexao.php");
      $stmt = $conn->prepare("DELETE FROM itens WHERE codigo = :codigo AND descricao = :descricao");
      $stmt->execute(["codigo" => $_GET["codigo"], "descricao" => $_GET["descricao"]]);
      $msg = htmlspecialchars("Item excluído com sucesso");
      header("Location: index.php?msg=$msg");
   } else {
        $msg = htmlspecialchars("Erro ao excluir item da lista");
        header("Location: index.php?msg=$msg");    
   }
?>