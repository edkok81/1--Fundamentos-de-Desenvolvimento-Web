
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
                $titulo = $conn->real_escape_string($_POST['titulo']);
                $isbn = $conn->real_escape_string($_POST['isbn']);
                $ano_publicacao = (int)$_POST['ano_publicacao'];
                $genero = $conn->real_escape_string($_POST['genero']);
                $autor_id = (int)$_POST['autor_id'];

                $stmt = $conn->prepare("INSERT INTO livros (titulo, isbn, ano_publicacao, genero, autor_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssisi", $titulo, $isbn, $ano_publicacao, $genero, $autor_id);
                if ($stmt->execute()) {
                    $message = "Livro adicionado com sucesso!";
                } else {
                    $message = "Erro ao adicionar livro: " . $stmt->error;
                }
                $stmt->close();
                break;
            case 'update':
                $id = (int)$_POST['id'];
                $titulo = $conn->real_escape_string($_POST['titulo']);
                $isbn = $conn->real_escape_string($_POST['isbn']);
                $ano_publicacao = (int)$_POST['ano_publicacao'];
                $genero = $conn->real_escape_string($_POST['genero']);
                $autor_id = (int)$_POST['autor_id'];

                $stmt = $conn->prepare("UPDATE livros SET titulo=?, isbn=?, ano_publicacao=?, genero=?, autor_id=? WHERE id=?");
                $stmt->bind_param("ssisii", $titulo, $isbn, $ano_publicacao, $genero, $autor_id, $id);
                if ($stmt->execute()) {
                    $message = "Livro atualizado com sucesso!";
                } else {
                    $message = "Erro ao atualizar livro: " . $stmt->error;
                }
                $stmt->close();
                break;
            case 'delete':
                $id = (int)$_POST['id'];
                $stmt = $conn->prepare("DELETE FROM livros WHERE id=?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $message = "Livro excluído com sucesso!";
                } else {
                    $message = "Erro ao excluir livro: " . $stmt->error;
                }
                $stmt->close();
                break;
        }
    }
}

// Lógica para SELECT (listar livros)
$livros = [];
$sql_select = "SELECT l.id, l.titulo, l.isbn, l.ano_publicacao, l.genero, a.nome as autor_nome, a.sobrenome as autor_sobrenome, a.id as autor_id FROM livros l JOIN autores a ON l.autor_id = a.id ORDER BY l.titulo";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }
}

$autores = [];
$sql_autores = "SELECT id, nome, sobrenome FROM autores ORDER BY nome";
$result_autores = $conn->query($sql_autores);
if ($result_autores->num_rows > 0) {
    while($row_autor = $result_autores->fetch_assoc()) {
        $autores[] = $row_autor;
    }
}

$db->closeConnection();
?>

<h1 class="mb-4">Gerenciar Livros</h1>

<?php if ($message): ?>
    <div class="alert alert-info" role="alert">
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">
        Adicionar Novo Livro
    </div>
    <div class="card-body">
        <form method="POST" action="livros.php">
            <input type="hidden" name="action" value="add">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="col-md-6">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                </div>
                <div class="col-md-4">
                    <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                    <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao">
                </div>
                <div class="col-md-4">
                    <label for="genero" class="form-label">Gênero</label>
                    <input type="text" class="form-control" id="genero" name="genero">
                </div>
                <div class="col-md-4">
                    <label for="autor_id" class="form-label">Autor</label>
                    <select class="form-select" id="autor_id" name="autor_id" required>
                        <option value="">Selecione um Autor</option>
                        <?php foreach ($autores as $autor): ?>
                            <option value="<?= $autor['id'] ?>"><?= htmlspecialchars($autor['nome'] . ' ' . $autor['sobrenome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Adicionar Livro</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Lista de Livros
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>ISBN</th>
                        <th>Ano</th>
                        <th>Gênero</th>
                        <th>Autor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($livros) > 0): ?>
                        <?php foreach ($livros as $livro): ?>
                            <tr>
                                <td><?= $livro['id'] ?></td>
                                <td><?= htmlspecialchars($livro['titulo']) ?></td>
                                <td><?= htmlspecialchars($livro['isbn']) ?></td>
                                <td><?= htmlspecialchars($livro['ano_publicacao']) ?></td>
                                <td><?= htmlspecialchars($livro['genero']) ?></td>
                                <td><?= htmlspecialchars($livro['autor_nome'] . ' ' . $livro['autor_sobrenome']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?= $livro['id'] ?>" 
                                        data-titulo="<?= htmlspecialchars($livro['titulo']) ?>" 
                                        data-isbn="<?= htmlspecialchars($livro['isbn']) ?>" 
                                        data-ano="<?= htmlspecialchars($livro['ano_publicacao']) ?>" 
                                        data-genero="<?= htmlspecialchars($livro['genero']) ?>" 
                                        data-autor_id="<?= htmlspecialchars($livro['autor_id']) ?>">
                                        Editar
                                    </button>
                                    <form method="POST" action="livros.php" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $livro['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Nenhum livro encontrado.</td>
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
                <h5 class="modal-title" id="editModalLabel">Editar Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="livros.php">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="edit_isbn" name="isbn" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_ano_publicacao" class="form-label">Ano de Publicação</label>
                        <input type="number" class="form-control" id="edit_ano_publicacao" name="ano_publicacao">
                    </div>
                    <div class="mb-3">
                        <label for="edit_genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="edit_genero" name="genero">
                    </div>
                    <div class="mb-3">
                        <label for="edit_autor_id" class="form-label">Autor</label>
                        <select class="form-select" id="edit_autor_id" name="autor_id" required>
                            <?php foreach ($autores as $autor): ?>
                                <option value="<?= $autor['id'] ?>"><?= htmlspecialchars($autor['nome'] . ' ' . $autor['sobrenome']) ?></option>
                            <?php endforeach; ?>
                        </select>
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
            const titulo = button.getAttribute('data-titulo');
            const isbn = button.getAttribute('data-isbn');
            const ano = button.getAttribute('data-ano');
            const genero = button.getAttribute('data-genero');
            const autor_id = button.getAttribute('data-autor_id');

            const modalTitle = editModal.querySelector('.modal-title');
            const modalBodyInputId = editModal.querySelector('#edit_id');
            const modalBodyInputTitulo = editModal.querySelector('#edit_titulo');
            const modalBodyInputIsbn = editModal.querySelector('#edit_isbn');
            const modalBodyInputAno = editModal.querySelector('#edit_ano_publicacao');
            const modalBodyInputGenero = editModal.querySelector('#edit_genero');
            const modalBodySelectAutor = editModal.querySelector('#edit_autor_id');

            modalTitle.textContent = 'Editar Livro: ' + titulo;
            modalBodyInputId.value = id;
            modalBodyInputTitulo.value = titulo;
            modalBodyInputIsbn.value = isbn;
            modalBodyInputAno.value = ano;
            modalBodyInputGenero.value = genero;
            modalBodySelectAutor.value = autor_id;
        });
    });
</script>

<?php
require_once __DIR__ . 
'/footer.php';
?>

