
<?php
require_once __DIR__ . 
'/header.php';
require_once __DIR__ . 
'/database.php';

$db = new Database();
$conn = $db->getConnection();

$total_livros = 0;
$total_autores = 0;
$total_usuarios = 0;

// Contar total de livros
$result_livros = $conn->query("SELECT COUNT(*) as total FROM livros");
if ($result_livros) {
    $total_livros = $result_livros->fetch_assoc()["total"];
}

// Contar total de autores
$result_autores = $conn->query("SELECT COUNT(*) as total FROM autores");
if ($result_autores) {
    $total_autores = $result_autores->fetch_assoc()["total"];
}

// Contar total de usuários
$result_usuarios = $conn->query("SELECT COUNT(*) as total FROM usuarios");
if ($result_usuarios) {
    $total_usuarios = $result_usuarios->fetch_assoc()["total"];
}

$db->closeConnection();
?>

<h1 class="mb-4">Bem-vindo(a) ao Dashboard, <?= htmlspecialchars($_SESSION["nome_usuario"]) ?>!</h1>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total de Livros</h5>
                <p class="card-text display-4"><?= $total_livros ?></p>
                <a href="livros.php" class="btn btn-primary">Ver Livros</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total de Autores</h5>
                <p class="card-text display-4"><?= $total_autores ?></p>
                <a href="autores.php" class="btn btn-primary">Ver Autores</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total de Usuários</h5>
                <p class="card-text display-4"><?= $total_usuarios ?></p>
                <!-- Acesso a usuários pode ser restrito a admins -->
                <?php if ($_SESSION["tipo_usuario"] === "admin"): ?>
                    <a href="#" class="btn btn-primary">Gerenciar Usuários</a>
                <?php else: ?>
                    <button class="btn btn-primary" disabled>Gerenciar Usuários</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . 
'/footer.php';
?>

