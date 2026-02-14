FROM composer:2 AS composer

FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libexif-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        intl \
        opcache \
        zip \
        gd \
        exif

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
