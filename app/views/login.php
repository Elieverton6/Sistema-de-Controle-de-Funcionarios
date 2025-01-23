<!DOCTYPE html> <!-- Declara o tipo de documento HTML5 -->
<html lang="pt-br"> <!-- Define o idioma da página como português do Brasil -->
<head>
    <!-- Definindo o charset como UTF-8 para garantir que caracteres especiais sejam exibidos corretamente -->
    <meta charset="UTF-8">
    
    <!-- Definindo a tag viewport para que o site seja responsivo e se adapte a dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Definindo o título da página que aparece na aba do navegador -->
    <title>Login</title>

    <!-- Importa o script do Font Awesome para utilizar ícones, como o ícone de olho para visualizar a senha -->
    <script src="https://kit.fontawesome.com/18a975bbae.js" crossorigin="anonymous"></script>

    <!-- Link para o arquivo de estilo CSS para a página de login -->
    <link rel="stylesheet" href="/controle_funcionarios/public/css/login.css">
    
    <!-- Conexão antecipada com o servidor de fontes do Google para melhorar a performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Importa a fonte "Roboto Condensed" do Google Fonts para estilizar o texto da página -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Div principal que envolve o formulário -->
    <div class="container">
        <!-- Início do formulário de login -->
        <form action="index.php?action=login" method="POST"> <!-- Envia os dados para "index.php" com o método POST -->
            
            <div class="logo">
                <!-- Exibe a imagem do logo -->
                <img src="/controle_funcionarios/public/images/logo.png" alt="Logo">
            </div>

            <!-- Caixa para o campo de email -->
            <div class="email-box">
                <!-- Rótulo para o campo de email -->
                <label for="email">Email:</label>
                <!-- Campo de entrada de email com um limite máximo de 50 caracteres -->
                <input type="email" name="login" id="email" maxlength="50">
            </div>

            <!-- Caixa para o campo de senha -->
            <div class="password-box">
                <!-- Rótulo para o campo de senha -->
                <label for="password">Senha:</label>
                <!-- Campo de entrada de senha com limite de 30 caracteres -->
                <input type="password" name="senha" id="password" maxlength="30">
                
                <!-- Ícone de olho para mostrar/ocultar a senha -->
                <span id="eye-icon" class="fa fa-eye" aria-hidden="true"></span>
            </div>

            <!-- Botão de login -->
            <button class="confirm-login" type="submit">Entrar</button>

            <!-- Exibe a mensagem de erro, se houver -->
            <?php if (isset($_SESSION['error_message'])): ?>
                <!-- Exibe a mensagem de erro com uma classe CSS para estilo -->
                <div class="error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Carrega o script JavaScript para funcionalidades adicionais, como exibir a senha ao clicar no ícone de olho -->
    <script src="/controle_funcionarios/public/js/login.js"></script>
</body>
</html>
