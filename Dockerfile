# ---------- Node build ----------
FROM node:20 AS node

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ---------- PHP + nginx ----------
FROM php:8.4-fpm

# nginxインストール
RUN apt-get update && apt-get install -y nginx

WORKDIR /var/www/html

# Laravelコード
COPY . .

# build成果物コピー
COPY --from=node /app/public/build ./public/build

# PHP拡張
RUN docker-php-ext-install pdo_mysql

# nginx設定コピー
COPY nginx.conf /etc/nginx/nginx.conf

# 権限
RUN chmod -R 775 storage bootstrap/cache

# 起動
CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm"]