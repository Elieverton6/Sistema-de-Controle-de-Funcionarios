<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Torna a página responsiva em dispositivos móveis -->
    <title>Cadastrar Funcionario</title>  <!-- Título da página -->
    
    <!-- Link para o arquivo CSS de estilo da página -->
    <link rel="stylesheet" href="/controle_funcionarios/public/css/cadastro_funcionario.css">
    
    <!-- Precarregando as fontes do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  <!-- Fonte Roboto Condensed -->
</head>
<body>
    <div class="container">  <!-- Contêiner principal do formulário -->
        <!-- Formulário para cadastro do funcionário -->
        <form action="index.php?action=cadastrar_funcionario" method="POST">
            <div class="logo">  <!-- Exibe o logo da empresa -->
                <img src="/controle_funcionarios/public/images/logo.png" alt="Logo">
            </div>
            
            <!-- Caixa de entrada para o nome do funcionário -->
            <div class="nome-box">
                <label for="nome">Nome:</label>  <!-- Rótulo para o campo de nome -->
                <input type="text" id="nome" name="nome" maxlength="50">  <!-- Campo de texto para o nome -->
            </div>

            <!-- Caixa de entrada para o CPF do funcionário -->
            <div class="cpf-box">
                <label for="cpf">CPF:</label>  <!-- Rótulo para o campo de CPF -->
                <input type="text" id="cpf" name="cpf" oninput="limparCPF()" maxlength="11">  <!-- Campo de texto para o CPF -->
            </div>

            <!-- Caixa de entrada para o RG do funcionário -->
            <div class="rg-box">
                <label for="rg">RG:</label>  <!-- Rótulo para o campo de RG -->
                <input type="text" id="rg" name="rg" maxlength="20">  <!-- Campo de texto para o RG -->
            </div>

            <!-- Caixa de entrada para o e-mail do funcionário -->
            <div class="email-box">
                <label for="email">Email:</label>  <!-- Rótulo para o campo de email -->
                <input type="email" id="email" name="email" maxlength="30">  <!-- Campo de texto para o e-mail -->
            </div>

            <!-- Caixa de seleção para escolher a empresa -->
            <div class="empresa-box">
                <label for="empresa">Empresa:</label>  <!-- Rótulo para a seleção de empresa -->
                <select name="empresa" id="empresa">  <!-- Lista de empresas para seleção -->
                    <?php
                    // Carrega as empresas cadastradas no banco de dados e exibe as opções
                    $query = "SELECT * FROM tbl_empresa";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtém todas as empresas
                    
                    // Itera sobre as empresas e as exibe como opções no select
                    foreach ($empresas as $empresa) {
                        echo "<option value='{$empresa['id_empresa']}'>{$empresa['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <!-- Botão para submeter o formulário -->
            <button class="confirm-cadastro" type="submit">Cadastrar Funcionário</button>

            <!-- Exibe mensagens de sucesso ou erro, se existirem -->
            <?php
            // Exibe a mensagem de sucesso, se definida na sessão
            if (isset($_SESSION['success_message'])) {
                echo "<div class='success-message'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']);  // Limpa a mensagem após exibição
            }

            // Exibe a mensagem de erro, se definida na sessão
            if (isset($_SESSION['error_message'])) {
                echo "<div class='error-message'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']);  // Limpa a mensagem após exibição
            }
            ?>
        </form>
    </div>

    <!-- Script externo para manipulação da página -->
    <script src="/controle_funcionarios/public/js/cadastro_funcionarios.js"></script>
</body>
</html>
