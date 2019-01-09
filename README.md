# FITURE E-COMMERCE B2B [Laravel 5.5]

## Features
- Administration Dashboard 
- Responsive Layout
- Bootstrap 4
- Font Awesome
- MongoDB databases support
- JavaScript / CSS minification
- JavaScript / CSS hashing
- Some very useful helper functions to ease your live :)

## System Requirements
To be able to run Laravel Boilerplate you have to meet the following requirements:

- PHP > 7.0
- PHP Extensions: PDO, cURL, Mbstring, Tokenizer, Mcrypt, XML, GD
- Npm >= 5.6.0
- Node.js > 6.0
- Composer > 1.0.0
- MongoDB PHP driver [here](http://php.net/manual/en/mongodb.installation.php)

## Installation
1. Install Composer using detailed installation instructions [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
2. Install NPM & Node.js using detailed installation instructions [here](https://www.npmjs.com/get-npm) [here](https://nodejs.org/en/download/package-manager/)

3. Clone repository
```
$ git clone https://github.com/sasori69/backend-ecommerce.git
```
4. Change into the working directory
```
$ cd backend-ecommerce
```
5. Copy `.env.example` to `.env` and modify according to your environment
```
$ cp .env.example .env
```
6. Install composer dependencies
```
$ composer install
```
7. An application key can be generated with the command
```
$ php artisan key:generate
```
8. Execute following commands to install other dependencies
```
$ npm install
$ npm run dev
```
9. Run these commands to create the tables within the defined database and populate seed data
```
$ php artisan migrate --seed
```
If you get an error like a `PDOException` try editing your `.env` file and change `DB_HOST=127.0.0.1` to `DB_HOST=localhost` or `DB_HOST=mysql` (for *docker-compose* environment).

## User Login
1. Root login

- username : ```root@asd.id```
- password : ```asdasd```

## Run
To start the PHP built-in server
```
$ php artisan serve --port=8080
or
$ php -S localhost:8080 -t public/
```

Now you can browse the site at [http://localhost:8080](http://localhost:8080)  🙌

## Error on Development

1. php.ini
- Make sure you have the MongoDB PHP driver installed. You can find installation instructions at http://php.net/manual/en/mongodb.installation.php

## License

This is internal-sourced software licensed under the [MIT license](LICENSE).
