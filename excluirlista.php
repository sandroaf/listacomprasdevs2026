<?php 
   if (isset($_GET["confirma"]) 
    && isset($_GET["codigo"]) 
    && isset($_GET["nome"])) {
      require_once("conexao.php");
      $stmt = $conn->prepare("DELETE FROM lista WHERE codigo = :codigo and nome = :nome");
      $stmt->execute(["codigo" => $_GET["codigo"], "nome" => $_GET["nome"]]);
      $msg = htmlspecialchars("Lista excluída com sucesso");
      header("Location: index.php?msg=$msg");
   } else {
        $msg = htmlspecialchars("Erro ao excluir lista");
        header("Location: index.php?msg=$msg");    
   }
?>