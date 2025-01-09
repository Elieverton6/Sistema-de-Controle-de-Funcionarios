# Sistema de Controle de Funcionários

## Descrição do Projeto

Este sistema foi desenvolvido para gerenciar informações sobre empresas e funcionários. Ele permite que você faça o cadastro de empresas e funcionários, visualize dados, edite informações e exporte relatórios. Além disso, o sistema permite fazer login, com autenticação via email e senha, e conta com um dashboard para visualização de dados de forma interativa.

---

## Funcionalidades

1. **Cadastro de Empresas**: Cadastro de empresas no sistema.
2. **Cadastro de Funcionários**: Cadastro de funcionários, com dados como nome, CPF, RG, email, salário e empresa associada.
3. **Edição de Funcionários**: Atualização das informações dos funcionários cadastrados, incluindo salário e bonificação.
4. **Exclusão de Funcionários**: Remoção de funcionários do sistema.
5. **Exportação de Funcionários**: Exportação dos dados dos funcionários para um arquivo PDF.
6. **Autenticação**: Login de usuários com email e senha, além da funcionalidade de logout.
7. **Cálculo de Bonificação**: Bonificação para funcionários com base no tempo de serviço (1 ano = 10% do salário, 5 anos ou mais = 20% do salário).

---

## Estrutura de Pastas

```plaintext
/
├── app/
│   ├── controllers/           # Controladores do sistema
│   │   ├── LoginController.php
│   │   ├── EmpresaController.php
│   │   └── FuncionarioController.php
│   ├── models/                # Modelos e classes de negócios
│   ├── views/                 # Arquivos de visualização (HTML)
│   │   ├── login.php
│   │   ├── dashboard.php
│   │   ├── cadastro_empresa.php
│   │   ├── cadastro_funcionario.php
│   │   ├── editar_funcionario.php
│   │   └── exportar_funcionarios.php
│   ├── config/                # Arquivos de configuração
│   │   └── db.php
│   ├── public/                # Arquivos públicos (CSS, JS, imagens)
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
├── .htaccess                  # Arquivo de configuração do Apache
├── index.php                  # Arquivo de entrada principal
└── README.md                  # Este arquivo
