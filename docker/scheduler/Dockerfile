FROM php:8.2-fpm

RUN docker-php-ext-install pdo_pgsql

COPY docker/app/crontab /etc/cron.d/crontab

CMD ["crond", "-f"]
