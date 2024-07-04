# MyCoffee - Backend

Backend para suporte da aplicação web MyCoffee.

## Índice

1. [Pré-requisitos](#pré-requisitos)
2. [Instalação](#instalação)
3. [Estrutura do Projeto](#estrutura-do-projeto)
4. [Endpoints/APIs Disponíveis](#endpointsapis-disponíveis)

## Pré-requisitos

- **PHP**: Versão 8.2 ou superior. [Instalação do PHP](https://www.php.net/manual/pt_BR/install.php).
- **Composer**: Ferramenta de gerenciamento de dependências para PHP. [Instalação do Composer](https://getcomposer.org/download/).
- **Extensões PHP**: Verifique se as extensões necessárias para as dependências estão habilitadas (geralmente indicadas nos requisitos de cada pacote).
- **Banco de Dados**: Configuração de um banco de dados suportado pelo Laravel (como MySQL, PostgreSQL, SQLite, etc.), conforme configurado no arquivo `.env`.

#### Observações:
- O Laravel Breeze, JWT Auth, Laravel Tinker e outros pacotes listados no `composer.json` serão instalados automaticamente via Composer.

## Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/Construcao-2024/MyCoffee-Backend.git
   cd MyCoffee-Backend
   ```

2. Instale as dependências do PHP utilizando o Composer:

   ```bash
   composer install
   ```

   Para atualizar as dependências, caso necessário:

   ```bash
   composer update
   ```

3. Copie o arquivo de exemplo de variáveis de ambiente e renomeie para `.env`:

   ```bash
   cp .env.example .env
   ```

4. Gere a chave da aplicação Laravel:

   ```bash
   php artisan key:generate
   ```

5. Configure seu banco de dados no arquivo `.env` conforme necessário.

6. Rode as migrações para criar as tabelas no banco de dados:

   ```bash
   php artisan migrate
   ```

7. Inicie o servidor de desenvolvimento:

   ```bash
   php artisan serve
   ```

## Estrutura do Projeto

- **.editorconfig**: Configurações para padronização de estilo de código entre diferentes editores.
- **.env.example**: Arquivo de exemplo para configuração das variáveis de ambiente do ambiente de desenvolvimento.
- **.gitattributes** e **.gitignore**: Configurações para o controle de versão Git, ignorando arquivos e definindo atributos.
- **artisan**: Interface de linha de comando do Laravel para tarefas de desenvolvimento.
- **composer.json** e **composer.lock**: Arquivos de configuração e bloqueio do Composer para gerenciamento de dependências PHP.
- **package-lock.json** e **package.json**: Arquivos de configuração para gerenciamento de dependências JavaScript.
- **phpunit.xml**: Configurações para execução de testes automatizados.
- **README.md**: Documentação principal do projeto.

### Diretório `app`

- **Controllers**: Controladores para lidar com a lógica de aplicação, organizados por entidade e funcionalidade.
- **Middleware**: Middlewares para adicionar camadas de lógica entre as requisições HTTP.
- **Requests**: Classes para validação de dados recebidos nas requisições.
- **Models**: Modelos que representam entidades do banco de dados e definem a interação com os dados.
- **Providers**: Provedores de serviços para configurações adicionais da aplicação.
- **Services**: Lógica de negócio encapsulada em serviços para operações mais complexas.

### Diretório `bootstrap`

- **app.php**: Inicialização da aplicação Laravel.
- **providers.php**: Registro de provedores de serviços adicionais.

### Diretório `config`

- Arquivos de configuração para diferentes aspectos da aplicação, como autenticação, banco de dados, sistema de arquivos, etc.

### Diretório `database`

- **factories**: Fábricas para criar dados fictícios durante o desenvolvimento e testes.
- **migrations**: Migrações para criação e alteração da estrutura do banco de dados.
- **seeders**: Seeders para popular o banco de dados com dados iniciais.

### Diretório `public`

- Arquivos acessíveis publicamente pela aplicação, como index.php e recursos estáticos (favicon, robots.txt).

### Diretório `resources`

- **views**: Arquivos de visualização da aplicação.
- **vendor/l5-swagger**: Configurações e views para a documentação da API com Swagger.

### Diretório `routes`

- Definição das rotas da aplicação separadas por contexto (API, autenticação, console, web).

### Diretório `storage`

- **app**: Arquivos gerados pela aplicação.
- **framework**: Arquivos temporários gerados pelo Laravel (cache, sessões, logs, etc.).

### Diretório `tests`

- **Feature**: Testes de funcionalidade que simulam interações completas da aplicação.
- **Unit**: Testes unitários focados em pequenas partes do código.

## Endpoints/APIs Disponíveis

### Clientes

- **Listar todos os clientes**: `GET /clientes`
- **Criar um novo cliente**: `POST /clientes`
- **Mostrar detalhes de um cliente específico**: `GET /clientes/{id}`
- **Atualizar informações de um cliente**: `PUT /clientes/{id}`
- **Remover um cliente**: `DELETE /clientes/{id}`

### Produtos

- **Listar todos os produtos**: `GET /produtos`
- **Criar um novo produto**: `POST /produtos`
- **Mostrar detalhes de um produto específico**: `GET /produtos/{id}`
- **Atualizar informações de um produto**: `PUT /produtos/{id}`
- **Remover um produto**: `DELETE /produtos/{id}`
- **Listar produtos por categoria**: `GET /produtosCategoria/{id}`

### Categorias

- **Listar todas as categorias**: `GET /categoria`
- **Criar uma nova categoria**: `POST /categoria`
- **Mostrar detalhes de uma categoria específica**: `GET /categoria/{id}`
- **Atualizar informações de uma categoria**: `PUT /categoria/{id}`
- **Remover uma categoria**: `DELETE /categoria/{id}`

### Planos, Cargos e Funcionários

- **Listar todos os planos**: `GET /plano`
- **Listar todos os cargos**: `GET /cargo`
- **Listar todos os funcionários**: `GET /funcionario`

### Autenticação

- **Autenticar usuário**: `POST /login`
- **Encerrar sessão de usuário**: `POST /logout`

### Carrinho e Compras

- **Adicionar produto ao carrinho**: `POST /carrinho` (requer autenticação)
- **Listar itens do carrinho**: `GET /carrinho` (requer autenticação)
- **Remover item do carrinho**: `DELETE /carrinho/{carrinhoProdutoId}` (requer autenticação)
- **Realizar compra**: `POST /compra` (requer autenticação)
- **Listar produtos de uma compra específica**: `GET /compra/{id}`
