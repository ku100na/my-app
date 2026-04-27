#!/usr/bin/env bash

set -e

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "Running migrations..."
php artisan migrate --force

echo "Caching config..."
php artisan config:cache