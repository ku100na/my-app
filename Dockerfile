# =========================
# 1. Frontend build (Vite)
# =========================
FROM node:20 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build


# =========================
# 2. PHP Runtime
# =========================
FROM php:8.3-cli

WORKDIR /var/www/html

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libxml2-dev \
    zlib1g-dev \
    libonig-dev \
    pkg-config \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        xml

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --no-dev \
    --optimize-autoloader

# アプリコピー
COPY . .

# Vite build成果物
COPY --from=node /app/public/build ./public/build

RUN php artisan optimize:clear || true \
    && php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan view:clear || true \
    && php artisan route:clear || true
    
# 権限
RUN chmod -R 775 storage bootstrap/cache

# Railway用ポート
EXPOSE 8080

# 起動
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]

