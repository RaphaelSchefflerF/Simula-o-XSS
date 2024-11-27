<?php
try {
    $db = new PDO('sqlite:tasks.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criação da tabela de usuários
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");

    // Criação da tabela de tarefas com relação ao usuário
    $db->exec("CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        task TEXT NOT NULL,
        user_id INTEGER NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
    exit();
}
?>
