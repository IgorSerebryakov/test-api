#!/bin/bash

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

chmod -R 777 storage

cp .env.example .env

php artisan key:generate

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate

php-fpm
