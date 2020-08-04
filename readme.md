# Ping CRM

A demo application to illustrate how Inertia.js works.

![](https://raw.githubusercontent.com/inertiajs/pingcrm/master/screenshot.png)

## Installation

1. Clone the repo locally:

```sh
git clone https://github.com/inertiajs/pingcrm.git pingcrm
cd pingcrm
```

> You can automate the following steps (works on linux and mac) by just running `make` command. 

2. Install PHP dependencies:

```sh
composer install
```

3. Install NPM dependencies:

```sh
npm ci
```

4. Build assets:

```sh
npm run dev
```

5. Setup configuration:

```sh
cp .env.example .env
```

6. Generate application key:

```sh
php artisan key:generate
```

7. Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

7. Run database migrations:

```sh
php artisan migrate
```

8. Run database seeder:

```sh
php artisan db:seed
```

9. Run the dev server (the output will give the address):

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
