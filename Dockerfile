FROM node:20 AS node

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


FROM php:8.4-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libxml2-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    xml \
    tokenizer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY . .

COPY --from=node /app/public/build ./public/build

RUN php artisan optimize:clear || true

RUN chmod -R 775 storage bootstrap/cache

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=$PORT"]