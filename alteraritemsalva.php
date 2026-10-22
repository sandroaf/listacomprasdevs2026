<?php
require_once __DIR__ . '/funcoes.php';
// A validação do servidor complementa as restrições do formulário HTML.
validarPost();

try {
    $codigo = validarCodigo($_POST['fcodigo'] ?? null);
    $descricao = validarTexto($_POST['fdescricao'] ?? null, 'Descrição', 150);
    $quantidade = validarQuantidade($_POST['fquantidade'] ?? null);
    require __DIR__ . '/conexao.php';
    buscarItem($conn, $codigo);
    // A data registra a modificação; o item continua associado à mesma lista.
    $stmt = $conn->prepare(
        'UPDATE itens SET descricao = :descricao, quantidade = :quantidade,
         datahora = CURRENT_TIMESTAMP WHERE codigo = :codigo'
    );
    $stmt->execute(['descricao' => $descricao, 'quantidade' => $quantidade, 'codigo' => $codigo]);
    redirecionar('Item alterado com sucesso!');
} catch (Throwable $e) {
    tratarErro($e);
}
