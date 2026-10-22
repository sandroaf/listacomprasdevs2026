<?php
require_once __DIR__ . '/funcoes.php';
// A validação do servidor complementa as restrições do formulário HTML.
validarPost();

try {
    $nome = validarTexto($_POST['fnome'] ?? null, 'Nome da lista', 100);
    require __DIR__ . '/conexao.php';
    // Os parâmetros mantêm os dados separados do comando SQL.
    $stmt = $conn->prepare('INSERT INTO lista (nome) VALUES (:nome)');
    $stmt->execute(['nome' => $nome]);
    redirecionar('Lista incluída com sucesso!');
} catch (Throwable $e) {
    tratarErro($e);
}
