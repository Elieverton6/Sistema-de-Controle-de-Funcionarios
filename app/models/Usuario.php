<?php
// Classe User para gerenciar o login do usuário
class User {
    private $conn;  // Conexão com o banco de dados
    private $table_name = "tbl_funcionario";  // Nome da tabela onde os usuários estão registrados

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;  // Armazena a conexão com o banco
    }

    // Método para realizar o login do usuário
    public function login($email, $senha) {
        // Query SQL para verificar se o email e a senha correspondem a um usuário
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email AND senha = :senha LIMIT 1";
        $stmt = $this->conn->prepare($query);  // Prepara a query

        // Vincula os parâmetros :email e :senha à consulta SQL
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", md5($senha));  // Aplica MD5 na senha para segurança (recomenda-se usar algo mais seguro como bcrypt)

        // Executa a query
        if ($stmt->execute()) {
            // Se houver um resultado (linha), o login é bem-sucedido
            if ($stmt->rowCount() > 0) {
                return true;  // Login bem-sucedido
            }
        }
        return false;  // Login falhou
    }
}
?>
