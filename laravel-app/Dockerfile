FROM php:8.4-cli

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html
