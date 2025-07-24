FROM php:8.3-fpm-alpine

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apk add --no-cache \
    curl \
    autoconf \
    build-base \
    bash \
    git \
    pcre-dev \
    linux-headers \
    libzip-dev \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    icu-dev

RUN apk --no-cache add shadow && \
    groupmod -o -g ${GROUP_ID} www-data && \
    usermod -o -u ${USER_ID} -g www-data www-data

# Установка и активация расширения Redis
RUN pecl install redis && docker-php-ext-enable redis

# Установка PHP-расширений
RUN docker-php-ext-install pdo_mysql opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD php-fpm