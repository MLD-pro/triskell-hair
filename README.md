Triskell’Hair

Triskell’Hair is a web application built with Symfony, using Twig, Doctrine ORM, EasyAdmin, and custom JavaScript for enhanced user interactions.
The project manages appointment requests, services, before/after achievements, a service area map, and includes a secure administration panel.

Installation
Requirements

PHP 8.2

Composer

MySQL

Local server (WAMP, MAMP, XAMPP, or Symfony CLI)

Node.js + npm

Required PHP extensions:
pdo_mysql, mbstring, openssl, intl, json, ctype

Clone the repository
git clone https://github.com/<your-username>/triskellhair.git
cd triskellhair

Install backend dependencies
composer install


This installs Symfony components, Doctrine ORM, EasyAdmin, Twig, and all required backend dependencies.

Environment configuration

Duplicate the environment file:

cp .env .env.local


Then edit .env.local with your personal configuration:

DATABASE_URL="mysql://root:@127.0.0.1:3306/triskellhair?charset=utf8mb4"
APP_ENV=dev
MAILER_DSN=smtp://localhost


.env.local must not be versioned, as it contains sensitive information.

Database creation

Create the database:

php bin/console doctrine:database:create


Run the migrations:

php bin/console doctrine:migrations:migrate


This generates all required tables, including:
User, Appointement, Service, Achievement, Location, and Appointement_Service (many-to-many link table).

Install and compile frontend assets

Install dependencies:

npm install


Build assets:

npm run build


Or use watch mode during development:

npm run watch

Run the application

Using Symfony CLI:

symfony serve


Default address:

http://localhost:8000/

Project Structure
/src
/Controller       → Page controllers (public & admin)
/Entity           → Doctrine entities (User, Appointement, Service…)
/Repository       → Repositories (data access layer)
/Form             → Symfony forms
/assets               → JavaScript, SCSS, Jest tests
/templates            → Twig templates (frontend + EasyAdmin)
public/               → Entry point (index.php) + compiled assets
config/               → Security, routes, services configuration files

Unit Tests

Unit tests have been implemented using Jest for some frontend JavaScript components—
notably the logic behind the burger menu system.

Run tests:

npm test


Test coverage includes:

Opening and closing the burger menu

Closing the menu when clicking on a link

Closing the menu when clicking the overlay

Jest displays the test results directly in the terminal.

License

This project was developed for educational purposes.
© 2025 Triskell’Hair — All rights reserved.
