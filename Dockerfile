FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www

COPY . .

RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install

CMD ["php-fpm"]
