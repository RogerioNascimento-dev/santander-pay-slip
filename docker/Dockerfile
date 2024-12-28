FROM php:8.2-cli

WORKDIR /var/www

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --chown=www:www . /var/www