FROM php:7.4.1-apache

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update \
  && apt-get install -y \
    libzip-dev \
    mariadb-client \
  && docker-php-ext-install \
    zip \
    pdo_mysql

COPY ./php.ini /usr/local/etc/php/
COPY ./html/ /var/www/html/
