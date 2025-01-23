<?php
// Verificar se o usuário está logado, se não estiver, redireciona para a página de login
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirecionar para o login caso não esteja logado
    exit;
}

// Consultar todos os funcionários cadastrados com informações de bonificação e tempo de empresa
$query = "SELECT f.id_funcionario, f.nome, f.cpf, f.email, f.data_cadastro, f.salario, 
                 (CASE 
                    WHEN TIMESTAMPDIFF(YEAR, f.data_cadastro, NOW()) >= 5 THEN f.salario * 0.2
                    WHEN TIMESTAMPDIFF(YEAR, f.data_cadastro, NOW()) >= 1 THEN f.salario * 0.1
                    ELSE 0
                END) AS bonificacao,
                TIMESTAMPDIFF(YEAR, f.data_cadastro, NOW()) AS anos_de_empresa
          FROM tbl_funcionario f";
$stmt = $db->prepare($query);
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Coleta os dados dos funcionários
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link para o arquivo CSS da página de dashboard -->
    <link rel="stylesheet" href="/controle_funcionarios/public/css/dashboard.css">
    
    <!-- Precarregando as fontes do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Verificar se há uma mensagem de sucesso na sessão e exibi-la
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . $_SESSION['success_message'] . ' ✅</div>';
        unset($_SESSION['success_message']); // Limpar a mensagem após exibição
    }
    ?>
    <div class="container">
        <div class="dashboard-nav-wrapper">
            <h1>Dashboard</h1>
            <nav>
                <!-- Links para navegar pelas páginas do sistema -->
                <a href="index.php?action=cadastrar_empresa">Cadastrar Empresa</a> |
                <a href="index.php?action=cadastrar_funcionario">Cadastrar Funcionário</a> |
                <a class="dashboard-logout" href="index.php?action=logout">Sair</a>
            </nav>
        </div>
        
        <main class="inicio-wrapper">
            <h2>Funcionários Cadastrados</h2>

            <!-- Exibe uma mensagem caso não existam funcionários cadastrados -->
            <?php if (empty($funcionarios)): ?>
                <div class="inicio-text-no-funcionarios">
                    <p>Não há funcionários cadastrados.</p>
                </div>
            <?php else: ?>
                <!-- Exibe a tabela com os dados dos funcionários -->
                <table border="1">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Data Cadastro</th>
                            <th>Salário</th>
                            <th>Bonificação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <?php 
                            // Determinar a cor da linha com base no tempo de empresa
                            $corLinha = '';
                            if ($funcionario['anos_de_empresa'] >= 5) {
                                $corLinha = 'style="background-color:rgb(255, 76, 76);"'; // Funcionários com mais de 5 anos
                            } elseif ($funcionario['anos_de_empresa'] >= 1) {
                                $corLinha = 'style="background-color:rgb(70, 169, 255);"'; // Funcionários com mais de 1 ano
                            }
                            ?>
                        <tr <?= $corLinha ?>>
                            <!-- Exibe as informações de cada funcionário -->
                            <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                            <td><?= htmlspecialchars($funcionario['cpf']) ?></td>
                            <td><?= htmlspecialchars($funcionario['email']) ?></td>
                            <td><?= date('d/m/Y', strtotime($funcionario['data_cadastro'])) ?></td>
                            <td>R$ <?= number_format($funcionario['salario'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($funcionario['bonificacao'], 2, ',', '.') ?></td>
                            <td>
                                <!-- Links para editar ou excluir o funcionário -->
                                <a href="index.php?action=editar_funcionario&id=<?= $funcionario['id_funcionario'] ?>">Editar</a> |
                                <a href="index.php?action=excluir_funcionario&id=<?= $funcionario['id_funcionario'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Exibe o botão para exportar os dados dos funcionários para PDF -->
                <form class="inicio-export-pdf-btn" action="index.php?action=exportar_funcionarios" method="post">
                    <button type="submit">Exportar para PDF</button>
                </form>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>
