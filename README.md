# Sistema de Controle de Funcionários

## Descrição do Projeto

Este sistema foi desenvolvido para gerenciar informações de empresas e funcionários. Com ele, é possível realizar o cadastro, a edição e a exclusão de dados, bem como exportar relatórios. Além disso, o sistema inclui autenticação via email e senha e um dashboard interativo para visualização de informações.

---

## Funcionalidades

- **Cadastro de Empresas:** Adicionar empresas ao sistema.  
- **Cadastro de Funcionários:** Inserir dados como nome, CPF, RG, email, salário e empresa associada.  
- **Edição de Funcionários:** Atualizar informações dos funcionários, incluindo salário e bonificações.  
- **Exclusão de Funcionários:** Remover funcionários do sistema.  
- **Exportação de Funcionários:** Gerar um relatório dos funcionários em formato PDF.  
- **Autenticação:** Login e logout seguro com email e senha.  
- **Cálculo de Bonificação:** Aplicação de bonificações com base no tempo de serviço:  
  - 1 ano: 10% do salário.  
  - 5 anos ou mais: 20% do salário.

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
│   ├── config/                # Configurações do sistema
│   │   └── db.php
│   ├── public/                # Recursos públicos (CSS, JS, imagens)
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
├── .htaccess                  # Configuração do servidor Apache
├── index.php                  # Entrada principal da aplicação
└── README.md                  # Arquivo de documentação
```

---

## Instalação

### Pré-requisitos

- PHP (versão 7.4 ou superior).  
- Composer instalado.  
- Servidor web (Apache ou Nginx).  
- Banco de dados MySQL configurado.

### Passos para Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. Instale as dependências com o Composer:
   ```bash
   composer install
   ```

3. Configure o banco de dados:
   - Edite o arquivo `app/config/db.php` e insira as credenciais do banco de dados.

4. Ajuste permissões (se necessário):
   ```bash
   chmod -R 755 storage
   ```

5. Inicie o servidor local:
   ```bash
   php -S localhost:8000 -t public
   ```

---

## Dependências

Este projeto utiliza as seguintes bibliotecas:

- **Composer:** Gerenciamento de pacotes.  
- **FPDF:** Criação de arquivos PDF.  
- **Setasign:** Ferramentas auxiliares para geração de PDFs.

Certifique-se de instalar todas as dependências via Composer.

---

## Contato

- **Email:** [swgamerbr406@gmail.com](mailto:swgamerbr406@gmail.com)  
- **LinkedIn:** [elieverton-gomes](https://www.linkedin.com/in/elieverton-gomes/)  

---
