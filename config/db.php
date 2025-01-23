<?php

// Definindo a classe Database para gerenciar a conexão com o banco de dados
class Database {
    // Definindo as variáveis de configuração do banco de dados (privadas, acessíveis apenas dentro da classe)
    private $host = 'localhost';  // Endereço do servidor MySQL (geralmente localhost para desenvolvimento local)
    private $db_name = 'controle_funcionarios';  // Nome do banco de dados a ser usado
    private $username = 'root';  // Usuário para acessar o banco de dados (comum em ambientes de desenvolvimento local)
    private $password = '';  // Senha para o usuário (vazia para desenvolvimento local, mas deve ser configurada para produção)
    public $conn;  // Variável pública que armazenará a conexão com o banco de dados

    // Método para estabelecer a conexão com o banco de dados
    public function connect() {
        $this->conn = null;  // Inicializa a variável de conexão como nula

        try {
            // Tenta estabelecer a conexão usando a classe PDO (PHP Data Objects)
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);

            // Configura a conexão para lançar exceções em caso de erro (modo de erro)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            // Se houver erro na conexão, captura a exceção e exibe a mensagem de erro
            echo "Erro na conexão: " . $e->getMessage();
        }

        // Retorna a conexão estabelecida ou null em caso de falha
        return $this->conn;
    }
}
?>
