# =========================
# Node stage（Vite build）
# =========================
FROM node:20 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build


# =========================
# PHP stage
# =========================
FROM php:8.4-cli

WORKDIR /var/www/html

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 依存定義コピー
COPY composer.json composer.lock ./

# vendor生成
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# アプリ本体コピー
COPY . .

# Vite build成果物を移す
COPY --from=node /app/public/build ./public/build

# Laravelキャッシュクリア
RUN php artisan optimize:clear || true

# 権限
RUN chmod -R 775 storage bootstrap/cache

# =========================
# 起動
# =========================
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t public"]