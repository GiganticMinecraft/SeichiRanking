FROM php:7.3-apache
WORKDIR /var/www/html/
RUN apt-get update && apt-get install libpng-dev libonig-dev libzip-dev zlib1g-dev libxml2-dev openssl -y && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/
RUN docker-php-ext-install pdo_mysql mysqli mbstring gd zip xml mbstring opcache
COPY ./docker/apache/conf/001-php-vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
COPY ./ ./
RUN chown -R www-data:www-data /var/www/html
RUN composer install
