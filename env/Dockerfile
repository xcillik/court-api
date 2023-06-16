FROM php:8.1-apache

RUN apt update && \
    apt install -y curl git zip libzip-dev

RUN a2enmod rewrite ssl

WORKDIR /var/www/court-api

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer