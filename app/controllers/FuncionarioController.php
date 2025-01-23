<?php

require_once __DIR__ . '/../models/Funcionario.php';  // Inclui o arquivo do modelo Funcionario

class FuncionarioController {
    private $conn;

    // Construtor que recebe a conexão com o banco de dados
    public function __construct($db) {
        $this->conn = $db; // Armazena a conexão para ser usada nos métodos
    }

    // Método para cadastrar um novo funcionário
    public function cadastrar_funcionario($nome, $cpf, $rg, $email, $empresa) {
        // Verifica se todos os campos obrigatórios foram preenchidos
        if (!empty($nome) && !empty($cpf) && !empty($email) && !empty($empresa)) {
            $funcionario = new Funcionario($this->conn);  // Cria um novo objeto Funcionario, passando a conexão
            $funcionario->nome = $nome;  // Atribui os valores aos atributos do objeto
            $funcionario->cpf = $cpf;
            $funcionario->rg = $rg;
            $funcionario->email = $email;
            $funcionario->empresa = $empresa;

            // Tenta cadastrar o funcionário no banco de dados
            if ($funcionario->cadastrar()) {
                $_SESSION['success_message'] = "Funcionário cadastrado com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao cadastrar funcionário.";
            }
        } else {
            $_SESSION['error_message'] = "Todos os campos são obrigatórios!"; // Caso algum campo esteja vazio
        }
    }

    // Método para editar os dados de um funcionário existente
    public function editar_funcionario($id_funcionario, $dados) {
        // Verifica se o ID do funcionário é válido
        if (!empty($id_funcionario) && is_numeric($id_funcionario)) {
            $funcionario = new Funcionario($this->conn);  // Cria um novo objeto Funcionario
            $funcionario->id_funcionario = $id_funcionario;  // Define o ID do funcionário a ser editado

            // Atribui os novos dados ao objeto
            $funcionario->nome = $dados['nome'] ?? '';
            $funcionario->cpf = $dados['cpf'] ?? '';
            $funcionario->email = $dados['email'] ?? '';
            $funcionario->salario = $dados['salario'] ?? '';
            $funcionario->data_cadastro = $dados['data_cadastro'] ?? '';

            // Tenta atualizar os dados do funcionário no banco
            if ($funcionario->atualizar()) {
                $_SESSION['success_message'] = "Funcionário atualizado com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar os dados do funcionário.";
            }
        } else {
            $_SESSION['error_message'] = "ID do funcionário inválido ou não fornecido.";  // Caso o ID não seja válido
        }
    }

    // Método para excluir um funcionário
    public function excluir_funcionario($id_funcionario) {
        $funcionario = new Funcionario($this->conn);  // Cria o objeto Funcionario
        $funcionario->id_funcionario = $id_funcionario;  // Define o ID do funcionário a ser excluído

        // Chama o método excluir() do modelo para remover o funcionário
        if ($funcionario->excluir()) {
            $_SESSION['success_message'] = "Funcionário excluído com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao excluir funcionário.";  // Caso ocorra algum erro
        }
    }
}
?>