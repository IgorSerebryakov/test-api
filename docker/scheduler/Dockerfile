FROM php:8.2-fpm

RUN apt-get update && apt-get install -y cron &&\
    docker-php-ext-install pdo_pgsql

COPY docker/app/crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN crontab /etc/cron.d/crontab

CMD ["sh", "-c", "cron -f"]
