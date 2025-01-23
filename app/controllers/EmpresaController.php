<?php

class EmpresaController {
    private $conn;

    // Construtor que recebe a conexão com o banco de dados e a armazena na variável $conn
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para cadastrar uma nova empresa
    public function cadastrar_empresa($nome) {
        // Verifica se o nome da empresa foi fornecido
        if (!empty($nome)) {
            // Prepara a query de inserção dos dados da empresa na tabela 'tbl_empresa'
            $query = "INSERT INTO tbl_empresa (nome) VALUES (:nome)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);  // Associa o nome da empresa à variável da query
            
            // Executa a query e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                // Se a empresa foi cadastrada com sucesso, define a mensagem de sucesso
                $_SESSION['success_message'] = "Empresa cadastrada com sucesso!";
            } else {
                // Caso ocorra um erro, define a mensagem de erro
                $_SESSION['error_message'] = "Erro ao cadastrar empresa.";
            }
        } else {
            // Se o nome não foi preenchido, exibe mensagem de erro
            $_SESSION['error_message'] = "Nome da empresa não pode estar vazio.";
        }
    }
}
?>
