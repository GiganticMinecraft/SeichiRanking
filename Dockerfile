FROM node:16 as node
FROM php:8.1-fpm as front-builder
# node command
COPY --from=node /usr/local/bin /usr/local/bin
# npm command
COPY --from=node /usr/local/lib /usr/local/lib
# yarn command
COPY --from=node /opt /opt
COPY package* /var/www/html/
RUN npm ci
COPY resources /var/www/html/resources
COPY gulpfile.js .
RUN npm run gulp

FROM php:8.1-fpm
RUN apt-get update && apt-get install libpng-dev libonig-dev libzip-dev zlib1g-dev libxml2-dev openssl -y && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/
RUN docker-php-ext-install pdo_mysql mysqli mbstring gd zip xml mbstring opcache
COPY ./docker/php/php.ini /usr/local/etc/php

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
WORKDIR /var/www/html
COPY --chown=www-data:www-data ./ ./
RUN composer install
COPY --from=front-builder --chown=www-data:www-data /var/www/html/ /var/www/html/

EXPOSE 9000
