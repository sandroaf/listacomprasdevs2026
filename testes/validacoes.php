<?php
// Testes de regras de entrada: não abrem conexão nem alteram o banco de dados.
require_once __DIR__ . '/../funcoes.php';
$testes = 0;
function conferir(bool $condicao, string $nome): void
{
    global $testes;
    if (!$condicao) {
        throw new RuntimeException('Falhou: ' . $nome);
    }
    $testes++;
}
function deveRejeitar(callable $acao, string $nome): void
{
    try {
        $acao();
    } catch (InvalidArgumentException $e) {
        conferir(true, $nome);
        return;
    }
    conferir(false, $nome);
}
conferir(validarCodigo('12') === 12, 'Código inteiro');
foreach ([null, [], '0', '-1', '1.5', '2147483648', '1 OR 1=1'] as $entrada) {
    deveRejeitar(fn() => validarCodigo($entrada), 'Código inválido');
}
conferir(validarTexto('  Café 🛒  ', 'Nome', 100) === 'Café 🛒', 'Texto com acento e emoji');
conferir(mb_strlen(validarTexto(str_repeat('á', 100), 'Nome', 100)) === 100, 'Limite em caracteres');
foreach ([null, [], '', '   ', str_repeat('á', 101), "\xff"] as $entrada) {
    deveRejeitar(fn() => validarTexto($entrada, 'Nome', 100), 'Texto inválido');
}
conferir(validarQuantidade('1.5') === '1.50', 'Decimal com duas casas');
conferir(validarQuantidade('1') === '1.00', 'Quantidade inteira');
conferir(validarQuantidade('0.01') === '0.01', 'Limite mínimo');
conferir(validarQuantidade('99999999.99') === '99999999.99', 'Limite máximo');
foreach ([null, [], '0', '-1', '1.001', '100000000', '1,50', '1e2', '', 'NaN'] as $entrada) {
    deveRejeitar(fn() => validarQuantidade($entrada), 'Quantidade inválida');
}
conferir(escapar('<b>"Café" & pão</b>') === '&lt;b&gt;&quot;Café&quot; &amp; pão&lt;/b&gt;', 'Escape HTML');
conferir(strlen(tokenCsrf()) === 64 && tokenCsrf() === tokenCsrf(), 'Token estável na sessão');
echo $testes . " verificações aprovadas.\n";
