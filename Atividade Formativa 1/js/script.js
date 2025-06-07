function mascaraCelular(event) {
    document.getElementById('celular').addEventListener('input', function(e) {
        // Remove tudo que não é dígito
        let numeros = this.value.replace(/\D/g, '');
        
        // Limita a 11 caracteres (DDD + 9 dígitos)
        if (numeros.length > 11) {
            numeros = numeros.substring(0, 11);
        }
        
        // Aplica a máscara quando o usuário termina de digitar
        if (numeros.length >= 11) {
            this.value = `(${numeros.substring(0,2)}) ${numeros.substring(2,7)}-${numeros.substring(7)}`;
        } else if (numeros.length > 2) {
            this.value = `(${numeros.substring(0,2)}) ${numeros.substring(2)}`;
        } else if (numeros.length > 0) {
            this.value = `(${numeros}`;
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Aplica máscara no formulário
    if (document.getElementById('celular')) {
        document.getElementById('celular').addEventListener('keydown', mascaraCelular);
    }
    
    // Exibe dados na página de confirmação
    if (document.getElementById('confNome')) {
        mostrarDados();
    }
});

function getUrlParametros() {
    const params = new URLSearchParams(window.location.search);
    return {
        nome: params.get('nome'),
        email: params.get('email'),
        celular: params.get('celular'),
        dataNasc: params.get('dataNasc'),
        termos: params.get('agree-term') ? 'Aceito' : 'Não aceito'
    };
}

function mostrarDados() {
    const dados = getUrlParametros();
    
    // Remove a exibição antiga (se existir)
    const dadosUsuario = document.getElementById('dadosUsuario');
    if (dadosUsuario) {
        dadosUsuario.style.display = 'none';
    }
    
    // Preenche os valores na tabela
    document.getElementById('confNome').value = dados.nome || '';
    document.querySelector('.column2-pacote div:nth-child(2) p').textContent = dados.nome || 'Não informado';
    document.getElementById('confEmail').value = dados.email || '';
    document.querySelector('.column2-pacote div:nth-child(3) p').textContent = dados.email || 'Não informado';
    document.getElementById('confCelular').value = dados.celular || '';
    document.querySelector('.column2-pacote div:nth-child(4) p').textContent = dados.celular || 'Não informado';
    document.getElementById('confDataNasc').value = dados.dataNasc || '';
    document.querySelector('.column2-pacote div:nth-child(5) p').textContent = 
        dados.dataNasc ? new Date(dados.dataNasc).toLocaleDateString('pt-BR') : 'Não informada';
    document.getElementById('confTermos').value = dados.termos;
    document.querySelector('.column2-pacote div:nth-child(6) p').textContent = dados.termos;
}

window.onload = function() {
    if (document.getElementById('confNome')) {
        mostrarDados();
    }
};