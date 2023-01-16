# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/iamprasanth/exception-monitor.git

Switch to the repo folder

    cd exception-monitor

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeds (**Set the database connection in .env before migrating**)

    php artisan db:seed


Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**Login with following credential**

    admin@test.com & admin@98#

**TL;DR command list**

    git clone https://github.com/iamprasanth/exception-monitor.git
    cd exception-monitor
    composer install
    cp .env.example .env
    php artisan migrate
    php artisan db:seed
    php artisan serve

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors
