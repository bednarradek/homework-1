FROM php:8.0-fpm

RUN apt-get update
RUN apt install zip unzip
USER www-data

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/src/app

COPY composer.* /usr/src/app
RUN composer install

COPY . /usr/src/app