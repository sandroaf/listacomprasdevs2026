<?php
require_once __DIR__ . '/funcoes.php';
// A validação do servidor complementa as restrições do formulário HTML.
validarPost();

try {
    $codigo = validarCodigo($_POST['fcodigo'] ?? null);
    require __DIR__ . '/conexao.php';
    // A chave primária identifica o item, sem depender da descrição do navegador.
    $stmt = $conn->prepare('DELETE FROM itens WHERE codigo = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    if ($stmt->rowCount() !== 1) {
        throw new InvalidArgumentException('Item não encontrado.');
    }
    redirecionar('Item excluído com sucesso!');
} catch (Throwable $e) {
    tratarErro($e);
}
