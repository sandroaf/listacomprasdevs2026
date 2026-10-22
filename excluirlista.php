<?php
require_once __DIR__ . '/funcoes.php';
validarPost();

try {
    $codigo = validarCodigo($_POST['fcodigo'] ?? null);
    require __DIR__ . '/conexao.php';
    // Confirmamos ou desfazemos as duas exclusões juntas nas tabelas InnoDB.
    $conn->beginTransaction();
    $stmt = $conn->prepare('SELECT codigo FROM lista WHERE codigo = :codigo FOR UPDATE');
    $stmt->execute(['codigo' => $codigo]);
    if ($stmt->fetch() === false) {
        throw new InvalidArgumentException('Lista não encontrada.');
    }
    // O bloqueio coordena a exclusão com os vínculos verificados pela chave estrangeira.
    $stmt = $conn->prepare('DELETE FROM itens WHERE codigo_lista = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    $stmt = $conn->prepare('DELETE FROM lista WHERE codigo = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('A lista não pôde ser excluída.');
    }
    $conn->commit();
    redirecionar('Lista excluída com sucesso!');
} catch (Throwable $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    tratarErro($e);
}
