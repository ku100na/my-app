FROM php:8.4-fpm
WORKDIR /var/www/html

# PHP依存
RUN apt-get update && apt-get install -y \
    curl git unzip zip gnupg \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo_mysql zip

# Node.js（Vite用・必須）
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 依存ファイルだけ先にコピー（キャッシュ最適化）
COPY package*.json ./
RUN npm install

# Laravelコード全部コピー
COPY . .

# PHP依存
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Viteビルド
RUN npm run build

# 権限
RUN chmod -R 775 storage bootstrap/cache

# 起動
CMD ["sh", "-c", "php artisan optimize:clear && php -S 0.0.0.0:$PORT -t public"]