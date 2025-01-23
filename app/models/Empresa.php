<?php

// Inclui os arquivos necessários para a conexão com o banco de dados e a lógica de cadastro da empresa
require_once '../config/db.php';  // Arquivo de configuração do banco de dados
require_once '../app/controllers/EmpresaController.php';  // Controlador para manipulação das empresas

// Cria uma instância da classe Database e conecta ao banco de dados
$db = (new Database())->connect();

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];  // Obtém o nome da empresa enviado no formulário

    // Cria uma instância do controlador de empresa e chama o método para cadastrar a empresa
    $empresaController = new EmpresaController($db);
    $empresaController->cadastrar_empresa($nome);  // Chama o método para cadastrar a empresa
}
?>
