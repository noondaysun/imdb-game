FROM php:7.4.11-fpm-alpine3.12
ARG uid=1000
ARG user=trivia
ARG password="#Secret1Password^"

RUN sed -i 's/http/https/g' /etc/apk/repositories && \
    apk update && \
    apk add --no-cache autoconf freetype-dev g++ gcc jpeg-dev libpng-dev libxml2-dev make zlib-dev nodejs npm && \
    apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    apk del .phpize-deps && \
    docker-php-ext-install -j$(nproc) bcmath exif gd pcntl pdo_mysql xml && \
    pecl install pcov redis && \
    docker-php-ext-enable pcov redis

RUN adduser -D --uid $uid --home /home/$user $user www-data,root && \
    echo "${user}:${password}" | chpasswd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
