<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Torna a página responsiva em dispositivos móveis -->
    <title>Cadastrar Empresa</title>  <!-- Título da página -->
    
    <!-- Link para o arquivo CSS de estilo da página -->
    <link rel="stylesheet" href="/controle_funcionarios/public/css/cadastro_empresa.css">
    
    <!-- Precarregando as fontes do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  <!-- Fonte Roboto Condensed -->
</head>
<body>
    <div class="container">  <!-- Contêiner principal do formulário -->
        <!-- Formulário para cadastro da empresa -->
        <form action="index.php?action=cadastrar_empresa" method="POST">
            <div class="logo">  <!-- Exibe o logo da empresa -->
                <img src="/controle_funcionarios/public/images/logo.png" alt="Logo">
            </div>
            
            <!-- Caixa de entrada para o nome da empresa -->
            <div class="cadastrar-empresa-box">
                <label for="nome">Nome da Empresa:</label>  <!-- Rótulo para o campo de nome -->
                <input type="text" id="nome" name="nome" maxlength="40">  <!-- Campo de texto para o nome da empresa -->
            </div>
            
            <!-- Botão para submeter o formulário -->
            <button class="confirm-cadastro" type="submit">Cadastrar Empresa</button>
            
            <!-- Exibe mensagens de sucesso ou erro, se existirem -->
            <?php
                // Exibe mensagem de sucesso, se estiver setada na sessão
                if (isset($_SESSION['success_message'])) {
                    echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
                    unset($_SESSION['success_message']); // Limpa a mensagem de sucesso após exibição
                }

                // Exibe mensagem de erro, se estiver setada na sessão
                if (isset($_SESSION['error_message'])) {
                    echo "<div class='error-message'>" . $_SESSION['error_message'] . "</div>";
                    unset($_SESSION['error_message']); // Limpa a mensagem de erro após exibição
                }
            ?>
        </form>
    </div>
</body>
</html>
