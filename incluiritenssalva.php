<?php
require_once __DIR__ . '/funcoes.php';
// A validação do servidor complementa as restrições do formulário HTML.
validarPost();

try {
    $codigoLista = validarCodigo($_POST['fcodigolista'] ?? null);
    $descricao = validarTexto($_POST['fdescricao'] ?? null, 'Descrição', 150);
    $quantidade = validarQuantidade($_POST['fquantidade'] ?? null);
    require __DIR__ . '/conexao.php';
    buscarLista($conn, $codigoLista);
    // O campo oculto é validado e a chave estrangeira verifica o vínculo no banco.
    $stmt = $conn->prepare(
        'INSERT INTO itens (descricao, quantidade, codigo_lista)
         VALUES (:descricao, :quantidade, :codigo_lista)'
    );
    $stmt->execute([
        'descricao' => $descricao,
        'quantidade' => $quantidade,
        'codigo_lista' => $codigoLista,
    ]);
    redirecionar('Item incluído com sucesso!');
} catch (Throwable $e) {
    tratarErro($e);
}
