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
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN echo "BUILD START" && npm run build && echo "BUILD END"

RUN npm cache clean --force
RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

CMD php artisan optimize:clear && php artisan serve --host=0.0.0.0 --port=${PORT}