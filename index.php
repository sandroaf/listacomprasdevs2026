<?php
require_once __DIR__ . '/funcoes.php';
require_once __DIR__ . '/conexao.php';

try {
    // Duas consultas atendem todas as listas, evitando uma consulta extra por lista.
    $stmt = $conn->query('SELECT codigo, nome FROM lista ORDER BY nome, codigo');
    $listas = $stmt->fetchAll();
    $stmt = $conn->query(
        'SELECT codigo, descricao, quantidade, codigo_lista, datahora
         FROM itens ORDER BY descricao, codigo'
    );
    $itensPorLista = [];
    foreach ($stmt->fetchAll() as $item) {
        $itensPorLista[$item['codigo_lista']][] = $item;
    }
} catch (PDOException $e) {
    error_log((string) $e);
    http_response_code(500);
    exit('Não foi possível consultar os dados. Confira a estrutura do banco no README.');
}
// Uma URL pode enviar um array no lugar de texto. Só aceitamos mensagem textual curta.
$mensagem = $_GET['msg'] ?? '';
if (!is_string($mensagem) || mb_strlen($mensagem, 'UTF-8') > 300) {
    $mensagem = '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Compras - DEVS TI 2026</title>
    <script src="funcoes.js" defer></script>
</head>
<body>
    <main>
        <h1>Lista de Compras - DEVS TI 2026</h1>
        <nav><a class="botao" href="incluirlista.php"><img src="img/add.png" class="icon" alt="">Incluir lista</a></nav>
        <?php if (!$listas): ?>
            <p>Não há listas cadastradas.</p>
        <?php else: ?>
            <ul class="listas">
            <?php foreach ($listas as $lista): ?>
                <li>
                    <div class="acoes">
                        <strong><?= escapar($lista['codigo']) ?> - <?= escapar($lista['nome']) ?></strong>
                        <!-- Só o identificador vai na URL; o nome é consultado no banco. -->
                        <a class="botao" href="incluiritens.php?<?= escapar(http_build_query(['codigo' => $lista['codigo']])) ?>" title="Incluir item" aria-label="Incluir item"><img class="icon" src="img/add.png" alt=""></a>
                        <a class="botao" href="alterarlista.php?<?= escapar(http_build_query(['codigo' => $lista['codigo']])) ?>" title="Alterar lista" aria-label="Alterar lista"><img class="icon" src="img/update.png" alt=""></a>
                        <!-- A exclusão usa POST com token. data-confirmar contém texto, não código JS. -->
                        <form action="excluirlista.php" method="post" data-confirmar="<?= escapar('Confirma exclusão da lista ' . $lista['nome'] . ' e de seus itens?') ?>">
                            <?php campoCsrf(); ?>
                            <input type="hidden" name="fcodigo" value="<?= escapar($lista['codigo']) ?>">
                            <button type="submit" title="Excluir lista" aria-label="Excluir lista"><img class="icon" src="img/delete.png" alt=""></button>
                        </form>
                    </div>
                    <?php if (empty($itensPorLista[$lista['codigo']])): ?>
                        <p>Esta lista ainda não possui itens.</p>
                    <?php else: ?>
                        <h2>Itens</h2>
                        <ul>
                        <?php foreach ($itensPorLista[$lista['codigo']] as $item): ?>
                            <li class="item acoes">
                                <span><?= escapar($item['descricao']) ?> — <?= escapar($item['quantidade']) ?> — <?= escapar($item['datahora']) ?></span>
                                <a class="botao" href="alteraritem.php?<?= escapar(http_build_query(['codigo' => $item['codigo']])) ?>" title="Alterar item" aria-label="Alterar item"><img class="icon" src="img/update.png" alt=""></a>
                                <form action="excluiritem.php" method="post" data-confirmar="<?= escapar('Confirma exclusão do item ' . $item['descricao'] . '?') ?>">
                                    <?php campoCsrf(); ?>
                                    <input type="hidden" name="fcodigo" value="<?= escapar($item['codigo']) ?>">
                                    <button type="submit" title="Excluir item" aria-label="Excluir item"><img class="icon" src="img/delete.png" alt=""></button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <footer><p id="msg" role="status"><?= escapar($mensagem) ?></p></footer>
    </main>
</body>
</html>
