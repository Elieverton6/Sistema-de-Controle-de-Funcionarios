<?php
class LoginController {
    private $conn;

    // Construtor para receber a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;  // Atribui a conexão ao atributo da classe
    }

    // Método para autenticar o login do usuário
    public function login($login, $senha) {
        // Query SQL para verificar se o usuário existe com o login e senha fornecidos
        $query = "SELECT * FROM tbl_usuario WHERE login = :login AND senha = MD5(:senha)";
        $stmt = $this->conn->prepare($query);  // Prepara a query
        $stmt->bindParam(':login', $login);  // Faz o binding da variável 'login'
        $stmt->bindParam(':senha', $senha);  // Faz o binding da variável 'senha'
    
        $stmt->execute();  // Executa a query
    
        // Se a consulta retornar algum resultado, o login é válido
        if ($stmt->rowCount() > 0) {
            session_start();  // Inicia a sessão para armazenar as variáveis de sessão
            $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Recupera os dados do usuário
            $_SESSION['user'] = $user['id_usuario'];  // Armazena o ID do usuário na sessão

            // Mensagem de sucesso e redirecionamento para o dashboard
            $_SESSION['success_message'] = "Bem-vindo, " . $user['login'] . "!";
            header("Location: index.php?action=dashboard");
            exit();  // Encerra o script após o redirecionamento
        } else {
            // Se o login ou senha estiverem incorretos
            $_SESSION['error_message'] = "Login ou senha inválidos!";
            header("Location: index.php?action=login");  // Redireciona para a página de login
            exit();  // Encerra o script após o redirecionamento
        }
    }
}
?>
