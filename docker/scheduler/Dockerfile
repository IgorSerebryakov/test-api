FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    cron

RUN docker-php-ext-install pdo_pgsql pcntl

RUN pecl install redis && docker-php-ext-enable redis

COPY docker/app/crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab

CMD ["sh", "-c", "cron -f"]
