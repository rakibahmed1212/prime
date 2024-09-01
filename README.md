## Dependencies

-   Laravel version: 11
-   PHP 8.2
-   mysql 8.0

## Installation

```
composer install
```

Copy `.env.example` file to `.env` file and set database information.

```
cp .env.example .env
```

Generate key in `.env` file.

```
php artisan key:generate
```

Migrate database migrations with seeds.

```
php artisan migrate:fresh --seed
```
