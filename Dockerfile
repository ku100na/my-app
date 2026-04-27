FROM php:8.4-fpm
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

CMD php artisan serve --host=0.0.0.0 --port=10000