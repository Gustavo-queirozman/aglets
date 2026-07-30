# Projeto Laravel

## Requisitos

Antes de iniciar, certifique-se de que os seguintes recursos estão instalados:

- PHP 8.2 ou superior
- Composer
- Banco de dados MariaDB
- Node.js 18+ e NPM
- Git

## Clonar o Projeto

```bash
git clone https://github.com/Gustavo-queirozman/aglets.git
cd aglets
```

## Instalar Dependências

### Dependências PHP

```bash
composer install
```

### Dependências Front-end

```bash
npm install
```

## Configurar Ambiente

Copie o arquivo de exemplo:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as variáveis de ambiente, principalmente:

```env
APP_NAME="Aglets"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aglets
DB_USERNAME=root
DB_PASSWORD=
```

## Gerar Chave da Aplicação

```bash
php artisan key:generate
```

## Executar Migrações

```bash
php artisan migrate
```

Caso existam seeders:

```bash
php artisan db:seed
```

Ou:

```bash
php artisan migrate --seed
```

## Compilar Assets

### Ambiente de Desenvolvimento

```bash
npm run dev
```

### Ambiente de Produção

```bash
npm run build
```

## Executar o Projeto

Inicie o servidor Laravel:

```bash
php artisan serve
```

A aplicação estará disponível em:

```text
http://127.0.0.1:8000
```

## Comandos Úteis

Limpar cache:

```bash
php artisan optimize:clear
```

Listar rotas:

```bash
php artisan route:list
```

Executar testes:

```bash
php artisan test
```

## Estrutura Recomendada para Deploy

1. Configurar variáveis de ambiente em produção.
2. Executar `composer install --no-dev --optimize-autoloader`.
3. Executar `php artisan migrate --force`.
4. Executar `npm run build`.
5. Configurar permissões das pastas `storage` e `bootstrap/cache`.

## Suporte

Em caso de dúvidas, consulte a documentação oficial do Laravel:

https://laravel.com/docs
