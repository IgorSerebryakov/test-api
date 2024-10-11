#!/bin/bash

composer install --no-interaction --prefer-dist --optimize-autoloader

cp .env.example .env

php artisan key:generate

php artisan config:clear
php artisan cache:clear

php artisan migrate --env=testing
php artisan migrate

php-fpm
