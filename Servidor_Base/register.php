<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        header('Location: login.php');
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        /* Reset básico */
        body, h1, p, form {
            margin: 0;
            padding: 0;
        }

        /* Estilo geral */
        body {
            font-family: Arial, sans-serif;
            background-color: #ADD8E6; /* Azul claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #007BFF;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <p style="margin-top: 15px;">
            <a href="login.php">Já possui uma conta? Faça login aqui.</a>
        </p>
    </div>
</body>
</html>
