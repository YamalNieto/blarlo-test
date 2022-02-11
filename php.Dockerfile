FROM php:8.0-apache
RUN apt-get update \
    && apt-get install -y  \
        libicu-dev \
        libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql intl zip