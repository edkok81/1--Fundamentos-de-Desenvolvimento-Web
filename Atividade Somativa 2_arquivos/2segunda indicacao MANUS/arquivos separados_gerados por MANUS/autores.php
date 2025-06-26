
<?php
require_once __DIR__ . 
'/header.php';
require_once __DIR__ . 
'/database.php';

// Redireciona se o usuário não for bibliotecário ou admin
if (!isset($_SESSION['user_id']) || ($_SESSION['tipo_usuario'] !== 'bibliotecario' && $_SESSION['tipo_usuario'] !== 'admin')) {
    header('Location: dashboard.php'); // Ou uma página de acesso negado
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$message = '';

// Lógica para INSERT, UPDATE, DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $nome = $conn->real_escape_string($_POST['nome']);
                $sobrenome = $conn->real_escape_string($_POST['sobrenome']);
                $nacionalidade = $conn->real_escape_string($_POST['nacionalidade']);

                $stmt = $conn->prepare("INSERT INTO autores (nome, sobrenome, nacionalidade) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $nome, $sobrenome, $nacionalidade);
                if ($stmt->execute()) {
                    $message = "Autor adicionado com sucesso!";
                } else {
                    $message = "Erro ao adicionar autor: " . $stmt->error;
                }
                $stmt->close();
                break;
            case 'update':
                $id = (int)$_POST['id'];
                $nome = $conn->real_escape_string($_POST['nome']);
                $sobrenome = $conn->real_escape_string($_POST['sobrenome']);
                $nacionalidade = $conn->real_escape_string($_POST['nacionalidade']);

                $stmt = $conn->prepare("UPDATE autores SET nome=?, sobrenome=?, nacionalidade=? WHERE id=?");
                $stmt->bind_param("sssi", $nome, $sobrenome, $nacionalidade, $id);
                if ($stmt->execute()) {
                    $message = "Autor atualizado com sucesso!";
                } else {
                    $message = "Erro ao atualizar autor: " . $stmt->error;
                }
                $stmt->close();
                break;
            case 'delete':
                $id = (int)$_POST['id'];
                $stmt = $conn->prepare("DELETE FROM autores WHERE id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Autor excluído com sucesso!";
                } else {
                    $message = "Erro ao excluir autor: " . $stmt->error;
                }
                $stmt->close();
                break;
        }
    }
}

// Lógica para SELECT (listar autores)
$autores = [];
$sql_select = "SELECT id, nome, sobrenome, nacionalidade FROM autores ORDER BY nome, sobrenome";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $autores[] = $row;
    }
}

$db->closeConnection();
?>

<h1 class="mb-4">Gerenciar Autores</h1>

<?php if ($message): ?>
    <div class="alert alert-info" role="alert">
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">
        Adicionar Novo Autor
    </div>
    <div class="card-body">
        <form method="POST" action="autores.php">
            <input type="hidden" name="action" value="add">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-4">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                </div>
                <div class="col-md-4">
                    <label for="nacionalidade" class="form-label">Nacionalidade</label>
                    <input type="text" class="form-control" id="nacionalidade" name="nacionalidade">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Adicionar Autor</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Lista de Autores
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Nacionalidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($autores) > 0): ?>
                        <?php foreach ($autores as $autor): ?>
                            <tr>
                                <td><?= $autor['id'] ?></td>
                                <td><?= htmlspecialchars($autor['nome']) ?></td>
                                <td><?= htmlspecialchars($autor['sobrenome']) ?></td>
                                <td><?= htmlspecialchars($autor['nacionalidade']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?= $autor['id'] ?>" 
                                        data-nome="<?= htmlspecialchars($autor['nome']) ?>" 
                                        data-sobrenome="<?= htmlspecialchars($autor['sobrenome']) ?>" 
                                        data-nacionalidade="<?= htmlspecialchars($autor['nacionalidade']) ?>">
                                        Editar
                                    </button>
                                    <form method="POST" action="autores.php" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir este autor? Isso também excluirá todos os livros associados a ele.');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $autor['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum autor encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Edição (Bootstrap) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Autor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="autores.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_sobrenome" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="edit_sobrenome" name="sobrenome" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nacionalidade" class="form-label">Nacionalidade</label>
                        <input type="text" class="form-control" id="edit_nacionalidade" name="nacionalidade">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const sobrenome = button.getAttribute('data-sobrenome');
            const nacionalidade = button.getAttribute('data-nacionalidade');

            const modalTitle = editModal.querySelector('.modal-title');
            const modalBodyInputId = editModal.querySelector('#edit_id');
            const modalBodyInputNome = editModal.querySelector('#edit_nome');
            const modalBodyInputSobrenome = editModal.querySelector('#edit_sobrenome');
            const modalBodyInputNacionalidade = editModal.querySelector('#edit_nacionalidade');

            modalTitle.textContent = 'Editar Autor: ' + nome + ' ' + sobrenome;
            modalBodyInputId.value = id;
            modalBodyInputNome.value = nome;
            modalBodyInputSobrenome.value = sobrenome;
            modalBodyInputNacionalidade.value = nacionalidade;
        });

        const deleteForms = document.querySelectorAll('form .btn-danger');
        deleteForms.forEach(button => {
            button.addEventListener('click', function(event) {
                if (!confirm('Tem certeza que deseja excluir este autor? Isso também excluirá todos os livros associados a ele.')) {
                    event.preventDefault();
                }
            });
        });
    });
</script>

<?php
require_once __DIR__ . 
'/footer.php';
?>

