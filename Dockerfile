FROM php:8.3-fpm

RUN apt-get update -q;
RUN apt-get install -q -y libpq-dev;
RUN docker-php-ext-install pdo pdo_pgsql pgsql;

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug;