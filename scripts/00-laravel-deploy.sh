#!/usr/bin/env bash
set -e  # <--- AÑADE ESTO: Detiene el script si un comando falla

echo "Running composer"
# Verifica que la ruta /var/www/html sea la correcta en tu entorno de Render
composer install --no-dev --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force