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
FROM php:8.4-fpm

WORKDIR /var/www/html

# システム依存
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo_mysql zip

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# まずcomposerファイルだけコピー
COPY composer.json composer.lock ./

# vendor生成
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# アプリ本体コピー
COPY . .

# Nodeビルド成果物コピー（Vite）
COPY --from=node /app/public/build ./public/build

# Laravelキャッシュクリア
RUN php artisan optimize:clear || true

# 権限
RUN chmod -R 775 storage bootstrap/cache

# =========================
# 起動
# =========================
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t public"]