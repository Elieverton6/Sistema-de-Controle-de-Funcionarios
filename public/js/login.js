// Adiciona um evento de clique no ícone do olho para alternar a visibilidade da senha
document.getElementById('eye-icon').addEventListener('click', function() {
    // Obtém o campo de senha
    const passwordField = document.getElementById('password');
    // 'this' refere-se ao ícone que foi clicado
    const icon = this;

    // Verifica se o tipo do campo de senha é 'password'
    if (passwordField.type === 'password') {
        // Se for 'password', muda para 'text', revelando a senha
        passwordField.type = 'text';
        // Remove o ícone de olho fechado
        icon.classList.remove('fa-eye');
        // Adiciona o ícone de olho aberto
        icon.classList.add('fa-eye-slash');
    } else {
        // Se já estiver visível, volta para 'password', ocultando a senha
        passwordField.type = 'password';
        // Remove o ícone de olho aberto
        icon.classList.remove('fa-eye-slash');
        // Adiciona o ícone de olho fechado
        icon.classList.add('fa-eye');
    }
});
