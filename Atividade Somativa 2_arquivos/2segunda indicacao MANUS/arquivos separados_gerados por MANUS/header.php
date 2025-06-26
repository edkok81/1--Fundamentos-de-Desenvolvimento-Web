
<?php
// header.php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Cores pastéis e discretas
$primary_color = "#B2DFDB"; // Verde Água Pastel
$secondary_color = "#E0F2F1"; // Verde Água Mais Claro
$text_color = "#424242"; // Cinza Escuro
$light_text_color = "#757575"; // Cinza Médio
$accent_color = "#FFCCBC"; // Laranja Pêssego Pastel
$background_color = "#F5F5F5"; // Cinza Muito Claro

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: <?= $background_color ?>;
            color: <?= $text_color ?>;
        }
        .navbar {
            background-color: <?= $primary_color ?> !important;
        }
        .navbar-brand, .nav-link {
            color: <?= $text_color ?> !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: <?= $light_text_color ?> !important;
        }
        .btn-primary {
            background-color: <?= $primary_color ?>;
            border-color: <?= $primary_color ?>;
            color: <?= $text_color ?>;
        }
        .btn-primary:hover {
            background-color: <?= $secondary_color ?>;
            border-color: <?= $secondary_color ?>;
            color: <?= $text_color ?>;
        }
        .btn-warning {
            background-color: <?= $accent_color ?>;
            border-color: <?= $accent_color ?>;
            color: <?= $text_color ?>;
        }
        .btn-warning:hover {
            background-color: #FFAB91;
            border-color: #FFAB91;
            color: <?= $text_color ?>;
        }
        .btn-danger {
            background-color: #EF9A9A; /* Vermelho Pastel */
            border-color: #EF9A9A;
            color: <?= $text_color ?>;
        }
        .btn-danger:hover {
            background-color: #E57373;
            border-color: #E57373;
            color: <?= $text_color ?>;
        }
        .table {
            background-color: #FFFFFF;
        }
        .table thead {
            background-color: <?= $secondary_color ?>;
            color: <?= $text_color ?>;
        }
        .form-control, .form-select {
            border-color: <?= $primary_color ?>;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(<?= hexdec(substr($primary_color, 1, 2)) ?>, <?= hexdec(substr($primary_color, 3, 2)) ?>, <?= hexdec(substr($primary_color, 5, 2)) ?>, 0.25);
            border-color: <?= $primary_color ?>;
        }
        .container {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .alert-info {
            background-color: <?= $secondary_color ?>;
            border-color: <?= $primary_color ?>;
            color: <?= $text_color ?>;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Biblioteca</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="livros.php">Livros</a></li>
                    <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">Olá, <?= htmlspecialchars($_SESSION["nome_usuario"]) ?> (<?= htmlspecialchars($_SESSION["tipo_usuario"]) ?>)</span>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

