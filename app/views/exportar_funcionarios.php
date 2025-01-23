<?php

// Verificar se o usuário está logado
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirecionar para login caso o usuário não esteja logado
    exit();
}

require_once '../vendor/autoload.php';  // Carrega o autoload do FPDF para usar a biblioteca de PDF
$pdf = new \FPDF();  // Instancia o objeto FPDF

// Definir tamanho de página A4 (210mm x 297mm) e margens 0 para ocupar 100% da largura e altura
$pdf->SetAutoPageBreak(false);  // Desabilitar quebra automática de página
$pdf->AddPage('P', 'A4');  // 'P' para paisagem e 'A4' para o tamanho da página

// Definir margens para 0
$pdf->SetMargins(0, 0, 0);  // Margens esquerda, topo e direita

// Definir título
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Lista de Funcionarios Cadastrados'), 0, 1, 'C'); // Título centralizado

// Definir largura total da página (sem as margens)
$larguraPagina = 210;  // A4 tem 210mm de largura
$larguraNome = $larguraPagina * 0.15;  // 15% da largura da página
$larguraCpf = $larguraPagina * 0.15;  // 15% da largura da página
$larguraEmail = $larguraPagina * 0.20;  // 20% da largura da página
$larguraDataCadastro = $larguraPagina * 0.20;  // 20% da largura da página
$larguraSalario = $larguraPagina * 0.15;  // 15% da largura da página
$larguraBonificacao = $larguraPagina * 0.15;  // 15% da largura da página

// Definir cabeçalhos da tabela
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($larguraNome, 10, utf8_decode('Nome'), 1, 0, 'C');  // Coluna Nome
$pdf->Cell($larguraCpf, 10, utf8_decode('CPF'), 1, 0, 'C');    // Coluna CPF
$pdf->Cell($larguraEmail, 10, utf8_decode('Email'), 1, 0, 'C');  // Coluna Email
$pdf->Cell($larguraDataCadastro, 10, utf8_decode('Data Cadastro'), 1, 0, 'C');  // Coluna Data Cadastro
$pdf->Cell($larguraSalario, 10, utf8_decode('Salário'), 1, 0, 'C');  // Coluna Salário
$pdf->Cell($larguraBonificacao, 10, utf8_decode('Bonificação'), 1, 1, 'C');  // Coluna Bonificação

// Consultar todos os funcionários
require_once '../config/db.php';  // Incluir a configuração do banco de dados
$query = "SELECT f.id_funcionario, f.nome, f.cpf, f.email, f.data_cadastro, f.salario, 
                  (CASE 
                      WHEN TIMESTAMPDIFF(YEAR, f.data_cadastro, NOW()) >= 5 THEN f.salario * 0.2
                      WHEN TIMESTAMPDIFF(YEAR, f.data_cadastro, NOW()) >= 1 THEN f.salario * 0.1
                      ELSE 0
                  END) AS bonificacao
           FROM tbl_funcionario f";  // Consulta SQL para obter os funcionários e calcular a bonificação
$stmt = $db->prepare($query);  // Preparar a consulta
$stmt->execute();  // Executar a consulta
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obter todos os resultados da consulta

// Adicionar dados dos funcionários na tabela
$pdf->SetFont('Arial', '', 10);
foreach ($funcionarios as $funcionario) {
    $dataCadastro = date('d/m/Y', strtotime($funcionario['data_cadastro']));  // Formatar a data de cadastro
    $bonificacao = 0;
    
    // Calcular a bonificação com base nos anos de empresa
    $intervalo = (new DateTime($funcionario['data_cadastro']))->diff(new DateTime());
    if ($intervalo->y >= 5) {
        $bonificacao = $funcionario['salario'] * 0.2;  // Bonificação de 20% para mais de 5 anos
    } elseif ($intervalo->y >= 1) {
        $bonificacao = $funcionario['salario'] * 0.1;  // Bonificação de 10% para mais de 1 ano
    }

    // Usando utf8_decode para garantir que caracteres acentuados sejam exibidos corretamente no PDF
    $pdf->Cell($larguraNome, 10, utf8_decode($funcionario['nome']), 1, 0, 'C');  // Nome
    $pdf->Cell($larguraCpf, 10, utf8_decode($funcionario['cpf']), 1, 0, 'C');    // CPF
    $pdf->Cell($larguraEmail, 10, utf8_decode($funcionario['email']), 1, 0, 'C');  // Email
    $pdf->Cell($larguraDataCadastro, 10, utf8_decode($dataCadastro), 1, 0, 'C');  // Data Cadastro
    $pdf->Cell($larguraSalario, 10, 'R$ ' . number_format($funcionario['salario'], 2, ',', '.'), 1, 0, 'C');  // Salário
    $pdf->Cell($larguraBonificacao, 10, 'R$ ' . number_format($bonificacao, 2, ',', '.'), 1, 1, 'C');  // Bonificação
}

// Gerar o PDF
$pdf->Output();  // Exibir o PDF gerado no navegador
exit();  // Garantir que o script termine após gerar o PDF
?>
