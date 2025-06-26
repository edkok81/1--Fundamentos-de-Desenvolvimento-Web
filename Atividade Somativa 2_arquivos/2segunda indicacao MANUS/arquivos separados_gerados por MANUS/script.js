
// script.js
document.addEventListener("DOMContentLoaded", function() {
    // Exemplo de validação de formulário (simplificado)
    const formLivro = document.querySelector("#formLivro");
    if (formLivro) {
        formLivro.addEventListener("submit", function(event) {
            const titulo = document.querySelector("#titulo").value;
            if (titulo.trim() === "") {
                alert("O título do livro não pode ser vazio!");
                event.preventDefault(); // Impede o envio do formulário
            }
        });
    }

    // Exemplo de confirmação de exclusão com modal do Bootstrap
    // Este script é mais genérico e pode ser usado para qualquer botão de exclusão
    // que tenha a classe 'btn-delete' e um atributo 'data-confirm-message'
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            const confirmMessage = this.getAttribute("data-confirm-message") || "Tem certeza que deseja excluir este item?";
            if (!confirm(confirmMessage)) {
                event.preventDefault(); // Impede a ação padrão (envio do formulário ou navegação)
            }
        });
    });

    // Lógica para preencher o modal de edição de livros (já está no livros.php, mas aqui para referência)
    // const editModal = document.getElementById('editModal');
    // if (editModal) {
    //     editModal.addEventListener('show.bs.modal', function (event) {
    //         const button = event.relatedTarget;
    //         const id = button.getAttribute('data-id');
    //         const titulo = button.getAttribute('data-titulo');
    //         // ... preencher outros campos
    //         editModal.querySelector('#edit_id').value = id;
    //         editModal.querySelector('#edit_titulo').value = titulo;
    //     });
    // }
});

