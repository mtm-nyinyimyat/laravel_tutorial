# Laravel Tutorial

A Laravel 13 application with authentication, item catalog management, and order handling (orders → order items → items).

## Requirements

| Tool | Version |
| --- | --- |
| PHP | `^8.4` (8.5 recommended) |
| Composer | 2.x |
| Node.js | `^20.19.0` or `>=22.12.0` |
| npm | 10.x+ |
| MySQL | 8.x (or compatible) |

PHP extensions commonly needed: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`.

## Features

- Register / login / logout (session auth)
- Profile update (name, email) and password change
- Items CRUD
- Orders CRUD with line items
- Sidebar navigation, breadcrumbs, confirmation dialogs, flash toasts

## Setup

### 1. Clone and install dependencies

```bash
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=
```

Create the MySQL database if it does not exist:

```sql
CREATE DATABASE database_name;
```

### 3. Migrate and seed

```bash
php artisan migrate
php artisan db:seed
```

Default seeded user:

- Email: `test@example.com`
- Password: `password`

### 4. Build frontend assets

```bash
npm run build
```

For local development with hot reload:

```bash
npm run dev
```

## Run the app

Option A — separate terminals:

```bash
php artisan serve
npm run dev
```

Option B — all services together:

```bash
composer run dev
```

Then open [http://localhost:8000](http://localhost:8000).

`/` redirects to `/login`.

## Main routes

| Path | Description |
| --- | --- |
| `/login`, `/register` | Authentication |
| `/dashboard` | Home after login |
| `/profile` | Edit profile and password |
| `/items` | Item list / CRUD |
| `/orders` | Order list / CRUD |

## Testing

```bash
php artisan test
```

Run a focused suite:

```bash
php artisan test --compact tests/Feature/Http/Controllers
```

## Useful commands

```bash
# Format PHP
vendor/bin/pint

# Rebuild assets
npm run build

# Fresh database
php artisan migrate:fresh --seed
```

## Project stack

- Laravel 13
- Blade + Tailwind CSS v4 + Vite 8
- Pest for tests
- MySQL
