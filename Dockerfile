FROM php:7.4.1-fpm

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update \
  && apt-get install -y \
    libonig-dev \
    libzip-dev \
    mariadb-client \
  && docker-php-ext-install \
    mbstring \
    zip \
    pdo_mysql

COPY ./php.ini /usr/local/etc/php/
COPY ./html/ /var/www/html/
COPY ./inc/ /var/www/inc/
