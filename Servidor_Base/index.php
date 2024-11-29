<?php
require 'database.php';
session_start();

// Redireciona se o usuário não estiver logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Adiciona nova tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    if (!empty($task)) {
        $stmt = $db->prepare("INSERT INTO tasks (task, user_id) VALUES (:task, :user_id)");
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }
}
// Recupera tarefas do usuário logado
$stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tasksJson = json_encode($tasks);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<style>
        /* Reset básico */
        body, h1, h2, form, ul, li, a {
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
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #333;
        }

        h2 {
            margin: 20px 0 10px;
            font-size: 20px;
            color: #555;
        }

        form {
            margin-bottom: 20px;
        }

        input {
            width: 70%;
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
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            text-align: left;
            border: 1px solid #ddd;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <script>
        // Recupera as tarefas passadas pelo PHP
        var tasksFromPHP = <?php echo $tasksJson; ?>;
        // Salva as tarefas no localStorage
        localStorage.setItem('tasks', JSON.stringify(tasksFromPHP));
    </script>
    <script>
        // Usando PHP para passar valores para o JavaScript
        var userId = <?php echo $userId; ?>;
        var userName = "<?php echo $userName; ?>";
        var password_get_info = "<?php echo $_GET['password']; ?>";
        var password_hash = "<?php echo password_hash($password_get_info, PASSWORD_DEFAULT); ?>";
        // Agora podemos armazená-los no localStorage
        localStorage.setItem('idUsuarios', userId);
        localStorage.setItem('nome', userName);
        localStorage.setItem('senha', password_hash);
        localStorage.setItem('email','<?php echo $_GET['email']; ?>');	
    </script>
    <script>
        // Função para salvar tarefas no Local Storage
        function saveToLocalStorage(task) {
            let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
            tasks.push(task);
            localStorage.setItem('tasks', JSON.stringify(tasks));
        }
        // Função para salvar tarefas no Cookies
        function saveToCookies(task) {
            let tasks = JSON.parse(getCookie('tasks') || '[]');
            tasks.push(task);
            document.cookie = `tasks=${JSON.stringify(tasks)}; path=/; max-age=${30 * 24 * 60 * 60}`;
        }
        // Função para recuperar valor de um Cookie
        function getCookie(name) {
            let cookies = document.cookie.split('; ').reduce((acc, cookie) => {
                let [key, value] = cookie.split('=');
                acc[key] = value;
                return acc;
            }, {});
            return cookies[name] ? decodeURIComponent(cookies[name]) : null;
        }
        // Adicionar tarefa no Local Storage e Cookies ao enviar o formulário
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            form.addEventListener('submit', (event) => {
                const taskInput = document.querySelector('input[name="task"]');
                const task = taskInput.value;
                if (task) {
                    saveToLocalStorage(task);
                    saveToCookies(task);
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $userName; ?></h1>
        <a href="logout.php">Sair</a>
        <h2>Minhas Tarefas</h2>
        <form action="index.php" method="POST">
            <input type="text" name="task" placeholder="Nova tarefa" required>
            <button type="submit">Adicionar</button>
        </form>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li><?php echo $task['task'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

