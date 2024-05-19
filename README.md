# Laravel Plaid Demo App

A demo application to learn plaid integration with laravel.

## Installation

```sh
git clone https://github.com/rahulkhimsuriya/laravel-vue-plaid-app-demo

cd laravel-vue-plaid-app-demo
```

Install PHP dependencies:

```sh
composer install
```

Install node dependencies and build assets:

```sh
npm install && npm run build
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly. [Read more](https://laravel.com/docs/8.x/database)

```sh
touch database/database.sqlite
```

Change database connection

```dotenv
DB_CONNECTION=sqlite
```

Run database migrations and seed database:

```sh
php artisan migrate --seed
```

Change Plaid credentials

```dotenv
PLAID_ENVIRONMENT=
PLAID_CLIENT_ID=
PLAID_SECRET=
```


Login credentials:

```
Email: admin@example.com
Password: password
```

Run the dev server ([click me](http://127.0.0.1:8000)):

```sh
php artisan serve
```

## Thank you.
