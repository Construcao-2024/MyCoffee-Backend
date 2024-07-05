<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Nome do Projeto

## Descrição
Uma breve descrição do que o seu projeto faz.

## Pré-requisitos
- [Node.js](https://nodejs.org/en/download/)
- [Composer](https://getcomposer.org/download/)
- [PHP](https://www.php.net/downloads.php)
- [PostgreSQL](https://www.postgresql.org/download/)

## Instruções de Configuração

### Backend (Laravel)
1. Clone o repositório:
    ```bash
    git clone https://github.com/Construcao-2024/MyCoffee-Backend
    ```
2. Navegue até a pasta do projeto:
    ```bash
    cd seu-repo
    ```
3. Instale as dependências do Composer:
    ```bash
    composer install
    ```
4. Copie o arquivo de configuração de ambiente:
    ```bash
    cp .env.example .env
    ```
5. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
6. Configure o arquivo `.env` com suas credenciais de banco de dados.

7. Execute as migrações do banco de dados:
    ```bash
    php artisan migrate
    ```
8. Inicie o servidor de desenvolvimento:
    ```bash
    php artisan serve
    ```

### Frontend (React)
1. Navegue até a pasta do frontend:
    ```bash
    cd frontend
    ```
2. Instale as dependências do npm:
    ```bash
    npm install
    ```
3. Inicie o servidor de desenvolvimento:
    ```bash
    npm start
    ```
