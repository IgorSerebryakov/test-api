FROM php:8.2-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y cron \
    libpq-dev

RUN docker-php-ext-install pdo_pgsql

RUN useradd -G www-data,root -u $uid -d /home/$user $user

COPY docker/app/crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab
