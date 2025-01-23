<?php

// Classe Funcionario para gerenciar as operações no banco de dados
class Funcionario {
    private $conn;
    private $table_name = "tbl_funcionario"; // Nome da tabela no banco de dados

    // Propriedades que representam os dados do funcionário
    public $data_cadastro; 
    public $id_funcionario;
    public $nome;
    public $cpf;
    public $rg;
    public $email;
    public $empresa;
    public $salario;
    public $bonificacao;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para cadastrar um funcionário na tabela
    public function cadastrar() {
        // A query SQL para inserir um novo funcionário
        $query = "INSERT INTO " . $this->table_name . " (nome, cpf, rg, email, id_empresa, data_cadastro) 
                  VALUES (:nome, :cpf, :rg, :email, :empresa, NOW())";

        // Preparando a consulta SQL
        $stmt = $this->conn->prepare($query);

        // Vincula os parâmetros à query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':rg', $this->rg);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':empresa', $this->empresa);

        // Executa a query e retorna true se a execução foi bem-sucedida
        if ($stmt->execute()) {
            return true;
        }

        return false;  // Retorna false em caso de erro
    }

    // Método para atualizar os dados de um funcionário
    public function atualizar() {
        // Calcula a bonificação antes de atualizar os dados
        $this->calcularBonificacao();

        // A query SQL para atualizar os dados do funcionário
        $query = "UPDATE " . $this->table_name . "
                  SET nome = :nome, cpf = :cpf, email = :email, salario = :salario, bonificacao = :bonificacao
                  WHERE id_funcionario = :id_funcionario";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Vincula os parâmetros à query
        $stmt->bindParam(':id_funcionario', $this->id_funcionario);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':salario', $this->salario);
        $stmt->bindParam(':bonificacao', $this->bonificacao);

        // Executa a query e retorna true se a execução foi bem-sucedida
        if ($stmt->execute()) {
            return true;
        }

        return false;  // Retorna false em caso de erro
    }

    // Método para calcular a bonificação com base no tempo de empresa
    private function calcularBonificacao() {
        // Lógica para calcular a bonificação
        $query = "SELECT data_cadastro FROM " . $this->table_name . " WHERE id_funcionario = :id_funcionario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_funcionario', $this->id_funcionario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $data_cadastro = $row['data_cadastro'];

            // Calcula a diferença de anos entre a data de cadastro e a data atual
            $diferenca_anos = (int)date_diff(date_create($data_cadastro), date_create())->format('%y');
            
            // Define a bonificação dependendo dos anos de serviço
            if ($diferenca_anos >= 5) {
                $this->bonificacao = $this->salario * 0.2; // 20% de bonificação
            } elseif ($diferenca_anos >= 1) {
                $this->bonificacao = $this->salario * 0.1; // 10% de bonificação
            } else {
                $this->bonificacao = 0;  // Nenhuma bonificação para menos de 1 ano
            }
        }
    }

    // Método para excluir um funcionário da tabela
    public function excluir() {
        // A consulta SQL para excluir um funcionário com base no ID
        $query = "DELETE FROM tbl_funcionario WHERE id_funcionario = :id_funcionario";

        // Preparando a consulta SQL
        $stmt = $this->conn->prepare($query);

        // Vincula o parâmetro de ID do funcionário
        $stmt->bindParam(':id_funcionario', $this->id_funcionario);

        // Executa a query e verifica se a exclusão foi bem-sucedida
        if ($stmt->execute()) {
            return true;  // Retorna true se a exclusão foi bem-sucedida
        }

        return false;  // Retorna false em caso de erro
    }
}
?>
