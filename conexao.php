<?php
require_once __DIR__ . '/acessos.php';

try {
    // O ambiente pode selecionar outro banco sem alterar a configuração local.
    $servidor = getenv('DB_HOST') ?: hostname;
    $nomeBanco = getenv('DB_NAME') ?: database;
    $usuarioBanco = getenv('DB_USER') ?: user;
    $senhaBanco = getenv('DB_PASSWORD');
    if ($senhaBanco === false) {
        $senhaBanco = password;
    }
    $portaBanco = getenv('DB_PORT') ?: '3306';
    // utf8mb4 preserva acentos e emojis na comunicação com o MySQL.
    $dsn = "mysql:host=$servidor;port=$portaBanco;dbname=$nomeBanco;charset=utf8mb4";
    $conn = new PDO($dsn, $usuarioBanco, $senhaBanco, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Não seguimos a execução com uma conexão inexistente nem exibimos o erro SQL.
    error_log((string) $e);
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Confira a configuração do servidor.');
}
