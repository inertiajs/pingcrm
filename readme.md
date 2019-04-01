# Ping CRM

A demo application to illustrate how Inertia.js works.

## Installation

Clone the repo locally:

```sh
git clone git@github.com:inertiajs/pingcrm.git pingcrm
cd pingcrm
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm install
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

Setup local database by editing `.env`. Use whatever database (MySQL, Postgres, SQLite) you'd like here.

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** johndoe@example.com
- **Password:** secret
