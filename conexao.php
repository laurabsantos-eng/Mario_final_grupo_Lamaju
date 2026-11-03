<?php
    $host = "127.0.0.1"; // Utilizar IP em vez de "localhost" para forçar o uso da porta TCP
    $port = "3306";
    $user = "root";
    $pass = "mysql";    // Se estiver a usar XAMPP padrão no Windows, altere para "" (senha vazia)
    $dbname = "pixel_word";

    try {
        // Conexão sem espaços na DSN
        $pdo = new PDO(
            "mysql:host=$host;port=$port;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        // Criar o banco de dados se não existir
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Selecionar o banco de dados
        $pdo->exec("USE `$dbname`");

        // Criar a tabela ranking
        $pdo->exec(
            "CREATE TABLE IF NOT EXISTS `ranking` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `nome` VARCHAR(50) NOT NULL,
                `moeda` INT NOT NULL,
                `pontos` INT NOT NULL,
                `data_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

    } catch (PDOException $e) { 
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'status' => 'error',
            'message' => 'Erro no Banco de Dados: ' . $e->getMessage()
        ]);

        exit;
    }
?>