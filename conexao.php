<?php
    require_once("acessos.php");

    try {
        $strbanco = "mysql:host=%s;dbname=%s";
        $banco = sprintf($strbanco,hostname,database);
        $conn = new PDO($banco,user,password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //echo "Conexão bem sucedida";
    } catch (PDOException $e) {
        echo ("ERRO! Não foi possível conectar ao Banco de Dados ".$e->getMessage());
    }
?>