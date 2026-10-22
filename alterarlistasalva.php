<?php
require_once __DIR__ . '/funcoes.php';
// A validação do servidor complementa as restrições do formulário HTML.
validarPost();

try {
    $codigo = validarCodigo($_POST['fcodigo'] ?? null);
    $nome = validarTexto($_POST['fnome'] ?? null, 'Nome da lista', 100);
    require __DIR__ . '/conexao.php';
    buscarLista($conn, $codigo);
    // WHERE restringe a alteração à lista escolhida, mesmo se o nome não mudar.
    $stmt = $conn->prepare('UPDATE lista SET nome = :nome WHERE codigo = :codigo');
    $stmt->execute(['nome' => $nome, 'codigo' => $codigo]);
    redirecionar('Lista alterada com sucesso!');
} catch (Throwable $e) {
    tratarErro($e);
}
