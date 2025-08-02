FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev pkg-config libssl-dev libicu-dev \
    && docker-php-ext-install pdo_mysql zip intl mbstring exif pcntl bcmath gd opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
