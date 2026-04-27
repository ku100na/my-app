#!/usr/bin/env bash
set -e

echo "Running migrations..."
php artisan migrate --force --step

echo "Running seeders..."
php artisan db:seed --force