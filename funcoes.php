<?php
// Carregue antes do HTML: a sessão guarda o token que protege os formulários.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'use_strict_mode' => true,
    ]);
}

function escapar($valor): string
{
    // Escape para texto HTML e atributos entre aspas; não é um escape SQL.
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirecionar(string $mensagem): never
{
    // A mensagem é codificada para a URL; 303 leva o navegador de volta por GET.
    header('Location: index.php?' . http_build_query(['msg' => $mensagem]), true, 303);
    exit; // header sozinho não interrompe o processamento.
}

function tokenCsrf(): string
{
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function campoCsrf(): void
{
    echo '<input type="hidden" name="csrf" value="' . escapar(tokenCsrf()) . '">';
}

function validarPost(): void
{
    // Toda gravação exige POST e um token que corresponda à sessão atual.
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        exit('Método não permitido. Envie o formulário da aplicação.');
    }
    $token = $_POST['csrf'] ?? null;
    if (!is_string($token) || !hash_equals(tokenCsrf(), $token)) {
        http_response_code(403);
        exit('Formulário inválido ou sessão expirada. Recarregue a página.');
    }
}

function validarCodigo($valor): int
{
    // Rejeitamos arrays, zero, negativos, frações e números fora do INT do banco.
    if (!is_string($valor) && !is_int($valor)) {
        throw new InvalidArgumentException('Informe um código válido.');
    }
    $codigo = filter_var($valor, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 2147483647],
    ]);
    if ($codigo === false) {
        throw new InvalidArgumentException('Informe um código válido.');
    }
    return $codigo;
}

function validarTexto($valor, string $campo, int $limite): string
{
    if (!is_string($valor) || !mb_check_encoding($valor, 'UTF-8')) {
        throw new InvalidArgumentException($campo . ': informe um texto válido.');
    }
    $texto = trim($valor);
    if ($texto === '' || mb_strlen($texto, 'UTF-8') > $limite) {
        throw new InvalidArgumentException($campo . ': use de 1 a ' . $limite . ' caracteres.');
    }
    return $texto;
}

function validarQuantidade($valor): string
{
    // DECIMAL(10,2): oito dígitos inteiros e duas casas. input number envia ponto.
    if (!is_string($valor)
        || !preg_match('/^(?:0|[1-9][0-9]{0,7})(?:\.[0-9]{1,2})?$/D', $valor)
        || (float) $valor <= 0) {
        throw new InvalidArgumentException('Quantidade: use de 0.01 a 99999999.99, com até duas casas decimais.');
    }
    // Completa casas sem arredondar nem converter o decimal em um float para gravar.
    $partes = explode('.', $valor);
    return $partes[0] . '.' . str_pad($partes[1] ?? '', 2, '0');
}

function buscarLista(PDO $conn, int $codigo): array
{
    $stmt = $conn->prepare('SELECT codigo, nome FROM lista WHERE codigo = :codigo');
    $stmt->execute(['codigo' => $codigo]);
    $lista = $stmt->fetch();
    if ($lista === false) {
        throw new InvalidArgumentException('Lista não encontrada.');
    }
    return $lista;
}

function buscarItem(PDO $conn, int $codigo): array
{
    // JOIN reúne o item e o nome de sua lista em uma única consulta.
    $stmt = $conn->prepare(
        'SELECT i.codigo, i.descricao, i.quantidade, i.codigo_lista, l.nome
         FROM itens AS i JOIN lista AS l ON l.codigo = i.codigo_lista
         WHERE i.codigo = :codigo'
    );
    $stmt->execute(['codigo' => $codigo]);
    $item = $stmt->fetch();
    if ($item === false) {
        throw new InvalidArgumentException('Item não encontrado.');
    }
    return $item;
}

function tratarErro(Throwable $erro): never
{
    // Erros de entrada podem ser explicados ao aluno. Detalhes técnicos ficam no log.
    if ($erro instanceof InvalidArgumentException) {
        redirecionar($erro->getMessage());
    }
    error_log((string) $erro);
    if ($erro instanceof PDOException && ($erro->errorInfo[1] ?? null) === 1062) {
        redirecionar('Já existe uma lista com esse nome. Escolha outro nome.');
    }
    redirecionar('Não foi possível concluir a operação. Tente novamente.');
}
