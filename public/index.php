<?php
// Inclusão dos arquivos necessários
require_once '../config/db.php'; // Arquivo de configuração do banco de dados
require_once '../app/controllers/LoginController.php'; // Controlador para login
require_once '../app/controllers/EmpresaController.php'; // Controlador para operações relacionadas a empresas
require_once '../app/controllers/FuncionarioController.php'; // Controlador para operações relacionadas a funcionários

session_start(); // Inicia a sessão para armazenar dados de login e mensagens

// Criar a conexão com o banco de dados uma única vez
$db = (new Database())->connect(); // Instancia e conecta ao banco de dados

// Verificar qual ação foi chamada, se não houver, considera a ação 'login'
$action = $_GET['action'] ?? 'login'; 

// Função para calcular bonificação com base na data de cadastro e salário
function calcularBonificacao($data_cadastro, $salario) {
    $salario = (float) $salario; // Converte o salário para tipo float
    $anos_de_empresa = date_diff(date_create($data_cadastro), date_create('now'))->y; // Calcula os anos de serviço

    // Aplica a bonificação de acordo com o tempo de empresa
    if ($anos_de_empresa >= 5) {
        return $salario * 0.2; // 20% de bonificação
    } elseif ($anos_de_empresa >= 1) {
        return $salario * 0.1; // 10% de bonificação
    }

    return 0; // Se menos de 1 ano, não há bonificação
}

switch ($action) {
    case 'login':
        // Verifica se o formulário foi submetido via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login']; // Captura o login (email)
            $senha = $_POST['senha']; // Captura a senha

            // Verifica se os campos não estão vazios
            if (empty($login) || empty($senha)) {
                $_SESSION['error_message'] = "Por favor preencha todos os campos!"; // Define mensagem de erro
                header("Location: index.php?action=login"); // Redireciona para a página de login
                exit();
            } else {
                // Cria uma instância do controlador de login e chama o método de autenticação
                $loginController = new LoginController($db);
                $loginController->login($login, $senha);
            }
        }
        include '../app/views/login.php'; // Inclui a visualização de login
        break;

    case 'dashboard':
        include '../app/views/dashboard.php'; // Inclui a visualização do dashboard
        break;

    case 'cadastrar_empresa':
        // Verifica se o formulário de cadastro de empresa foi enviado via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome']; // Captura o nome da empresa
            // Cria uma instância do controlador de empresa e chama o método de cadastro
            $empresaController = new EmpresaController($db);
            $empresaController->cadastrar_empresa($nome);
        }
        include '../app/views/cadastro_empresa.php'; // Inclui a visualização de cadastro de empresa
        break;

    case 'cadastrar_funcionario':
        // Verifica se o formulário de cadastro de funcionário foi enviado via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $rg = $_POST['rg'];
            $email = $_POST['email'];
            $empresa = $_POST['empresa'];

            // Cria uma instância do controlador de funcionário e chama o método de cadastro
            $funcionarioController = new FuncionarioController($db);
            $funcionarioController->cadastrar_funcionario($nome, $cpf, $rg, $email, $empresa);
        }
        include '../app/views/cadastro_funcionario.php'; // Inclui a visualização de cadastro de funcionário
        break;

    case 'editar_funcionario':
        // Verifica se um ID de funcionário válido foi passado via GET
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id_funcionario = $_GET['id'];

            // Consulta os dados do funcionário pelo ID
            $query = "SELECT * FROM tbl_funcionario WHERE id_funcionario = :id_funcionario";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_funcionario', $id_funcionario);
            $stmt->execute();

            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém os dados do funcionário

            if ($funcionario) {
                include '../app/views/editar_funcionario.php'; // Inclui a visualização de edição de funcionário
            } else {
                $_SESSION['error_message'] = "Funcionário não encontrado."; // Se o funcionário não for encontrado
                header("Location: index.php"); // Redireciona de volta para a página principal
                exit();
            }
        } else {
            $_SESSION['error_message'] = "ID do funcionário inválido."; // Se o ID for inválido
            header("Location: index.php"); // Redireciona de volta para a página principal
            exit();
        }
        break;

    case 'atualizar_funcionario':
        // Verifica se o formulário de atualização foi enviado via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_funcionario = $_GET['id'];
            $nome = $_POST['nome'] ?? '';
            $cpf = $_POST['cpf'] ?? '';
            $email = $_POST['email'] ?? '';
            $salario = $_POST['salario'] ?? '';
            $data_cadastro = $_POST['data_cadastro'] ?? '';

            // Calcula a bonificação com base na data de cadastro e no salário
            $bonificacao = calcularBonificacao($data_cadastro, $salario);

            // Atualiza os dados do funcionário no banco de dados
            $query = "UPDATE tbl_funcionario SET 
                        nome = :nome, cpf = :cpf, email = :email, salario = :salario, 
                        data_cadastro = :data_cadastro, bonificacao = :bonificacao 
                      WHERE id_funcionario = :id_funcionario";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':salario', $salario);
            $stmt->bindParam(':data_cadastro', $data_cadastro);
            $stmt->bindParam(':bonificacao', $bonificacao);
            $stmt->bindParam(':id_funcionario', $id_funcionario);

            // Verifica se a atualização foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Funcionário atualizado com sucesso!"; // Mensagem de sucesso
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar os dados do funcionário."; // Mensagem de erro
            }

            header("Location: index.php?action=editar_funcionario&id=" . $id_funcionario); // Redireciona de volta para a página de edição
            exit();
        }
        break;

    case 'exportar_funcionarios':
        include __DIR__ . '/../app/views/exportar_funcionarios.php'; // Inclui a visualização para exportar a lista de funcionários
        break;

    case 'excluir_funcionario':
        // Verifica se um ID de funcionário válido foi passado via GET para exclusão
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id_funcionario = $_GET['id'];

            // Preparar a consulta para excluir o funcionário
            $query = "DELETE FROM tbl_funcionario WHERE id_funcionario = :id_funcionario";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_funcionario', $id_funcionario);

            // Verifica se a exclusão foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Funcionário excluído com sucesso!"; // Mensagem de sucesso
            } else {
                $_SESSION['error_message'] = "Erro ao excluir o funcionário."; // Mensagem de erro
            }

            // Redireciona de volta para a página do dashboard
            header("Location: index.php?action=dashboard");
            exit();
        } else {
            $_SESSION['error_message'] = "ID do funcionário inválido."; // Mensagem de erro se o ID for inválido
            header("Location: index.php?action=dashboard");
            exit();
        }
        break;

    case 'logout':
        include '../app/views/logout.php'; // Inclui a visualização de logout
        break;

    default:
        echo "Página não encontrada."; // Caso a ação seja inválida
}
?>