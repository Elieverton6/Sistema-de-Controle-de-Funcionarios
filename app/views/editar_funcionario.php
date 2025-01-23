<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionario</title>
    <!-- Link para o arquivo CSS da página de edição de funcionário -->
    <link rel="stylesheet" href="/controle_funcionarios/public/css/editar_funcionario.css">
    
    <!-- Precarregando as fontes do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Formulário para editar os dados do funcionário -->
        <form action="index.php?action=atualizar_funcionario&id=<?= $id_funcionario ?>" method="post">
            <div class="logo">
                <!-- Logo da empresa -->
                <img src="/controle_funcionarios/public/images/logo.png" alt="Logo">
            </div>
            
            <!-- Campo para o nome do funcionário -->
            <div class="nome-box">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= isset($funcionario['nome']) ? htmlspecialchars($funcionario['nome']) : '' ?>" maxlength="50">
            </div>

            <!-- Campo para o CPF do funcionário -->
            <div class="cpf-box">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="11" value="<?= isset($funcionario['cpf']) ? htmlspecialchars($funcionario['cpf']) : '' ?>">
            </div>

            <!-- Campo para o RG do funcionário -->
            <div class="rg-box">
                <label for="rg">RG:</label>
                <input type="text" id="rg" name="rg" maxlength="20" value="<?= isset($funcionario['rg']) ? htmlspecialchars($funcionario['rg']) : '' ?>">
            </div>

            <!-- Campo para o email do funcionário -->
            <div class="email-box">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= isset($funcionario['email']) ? htmlspecialchars($funcionario['email']) : '' ?>" maxlength="30">
            </div>

            <!-- Campo para o salário do funcionário -->
            <div class="salario-box">
                <label for="salario">Salário:</label>
                <input type="number" id="salario" name="salario" value="<?= isset($funcionario['salario']) ? htmlspecialchars($funcionario['salario']) : '' ?>" step="0.01">
            </div>

            <!-- Campo para a data de cadastro do funcionário -->
            <div class="data-cadastro-box">
                <label for="salario">Data Cadastro:</label>
                <input type="date" name="data_cadastro" value="<?php echo $funcionario['data_cadastro']; ?>" />
            </div>

            <!-- Botão para confirmar a edição -->
            <button class="confirm-edit" type="submit">Salvar</button>
            
            <!-- Exibe mensagem de sucesso caso esteja presente na sessão -->
            <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Exibe mensagem de erro caso esteja presente na sessão -->
            <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </form>
    </div>

    <!-- Link para o arquivo JavaScript da página -->
    <script src="/controle_funcionarios/public/js/editar_funcionario.js"></script>
</body>
</html>
