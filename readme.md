# Ping CRM

A demo application to illustrate how Inertia.js works.

![](https://raw.githubusercontent.com/inertiajs/pingcrm/master/screenshot.png)

## Installation

Clone the repo locally:

```sh
git clone https://github.com/inertiajs/pingcrm.git pingcrm
cd pingcrm
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** johndoe@example.com
- **Password:** secret

## Running tests

To run the Ping CRM tests, run:

```
phpunit
```

## Running with Laravel Sail

Add the following to your .env

```
DB_DATABASE=pingcrm
DB_USERNAME=pingcrm_user
DB_PASSWORD=pingcrm_password
DB_HOST=mysql // Make sure the host is now mysql
```

Run the containers:

```
./vendor/bin/sail up -d
```

Generate application key:

```
./vendor/bin/sail artisan key:generate
```

Run migrations and seeders:

```
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

Run NPM:

```
./vendor/bin/sail npm install
./vendor/bin/sail npm run watch
```
