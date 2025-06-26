<?php
session_start();
require_once __DIR__ . 
'/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, nome_usuario, email, senha, tipo_usuario FROM usuarios WHERE nome_usuario = ? OR email = ?");
    $stmt->bind_param("ss", $nome_usuario, $nome_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nome_usuario'] = $user['nome_usuario'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            header('Location: dashboard.php');
            exit();
        } else {
            $message = 'Senha incorreta.';
        }
    } else {
        $message = 'Usuário não encontrado.';
    }

    $stmt->close();
    $db->closeConnection();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciamento de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            color: #6c757d; /* Muted gray for heading */
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-primary {
            background-color: #6c757d; /* Muted gray for button */
            border-color: #6c757d;
        }
        .btn-primary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="nome_usuario" class="form-label">Usuário ou Email</label>
                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

