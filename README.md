# Aglets

API Laravel para gerenciamento de produtos.

## Requisitos

- PHP 8.2 ou superior
- Composer
- MariaDB ou MySQL
- Node.js 18+ e npm
- Git
- Redis opcional

## Clonar o projeto

```bash
git clone https://github.com/Gustavo-queirozman/aglets.git
cd aglets
```

## Instalação

Instale as dependências do backend:

```bash
composer install
```

Instale as dependências do frontend:

```bash
npm install
```

Copie o arquivo de ambiente:

```bash
cp .env.example .env
```

No Windows PowerShell, você também pode usar:

```powershell
Copy-Item .env.example .env
```

## Configuração do ambiente

Edite o arquivo `.env` com os dados da aplicação e do banco:

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

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Execute as migrations:

```bash
php artisan migrate
```

Se necessário, rode os seeders:

```bash
php artisan db:seed
```

Ou:

```bash
php artisan migrate --seed
```

## Redis

O projeto já possui suporte a Redis e inclui a dependência `predis/predis` no `composer.json`.

Por padrão, a aplicação usa:

- `CACHE_STORE=database`
- `QUEUE_CONNECTION=database`
- `SESSION_DRIVER=database`

Se quiser usar Redis, configure as variáveis abaixo no `.env`:

```env
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1
```

Se a extensão `phpredis` não estiver instalada, o projeto pode usar `predis` como cliente Redis.

### Usar Redis para cache

```env
CACHE_STORE=redis
```

### Usar Redis para filas

```env
QUEUE_CONNECTION=redis
REDIS_QUEUE=default
REDIS_QUEUE_CONNECTION=default
REDIS_QUEUE_RETRY_AFTER=90
```

Inicie o worker de filas:

```bash
php artisan queue:work redis
```

### Usar Redis para sessão

```env
SESSION_DRIVER=redis
SESSION_CONNECTION=default
SESSION_STORE=redis
```

Observação: para sessão em Redis, o store `redis` já está definido em `config/cache.php`.

## Executar o projeto

Para ambiente local simples:

```bash
php artisan serve
```

A aplicação ficará disponível em:

```text
http://127.0.0.1:8000
```

Para desenvolvimento completo com servidor, fila, logs e Vite:

```bash
composer run dev
```

## Assets

Modo desenvolvimento:

```bash
npm run dev
```

Build de produção:

```bash
npm run build
```

## Endpoints principais

- `GET /api/products`
- `GET /api/product/{id}`
- `POST /api/product`
- `PUT /api/product/{id}`
- `PATCH /api/product/{id}`
- `DELETE /api/product/{id}`

## Comandos úteis

Limpar caches:

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

## Deploy

Fluxo recomendado:

1. Configurar as variáveis de ambiente de produção.
2. Executar `composer install --no-dev --optimize-autoloader`.
3. Executar `php artisan migrate --force`.
4. Executar `npm run build`.
5. Garantir permissões para `storage` e `bootstrap/cache`.
6. Se estiver usando Redis para filas, iniciar um worker em produção.

## Suporte

Documentação oficial do Laravel:

[https://laravel.com/docs](https://laravel.com/docs)
