#!/bin/bash
set -e

# Permisos
chmod -R 777 /app/storage /app/bootstrap/cache /tmp

# Migrations y optimize
php artisan migrate --force --graceful
php artisan optimize

# Reemplazar PORT en nginx config
sed -i "s/RAILWAY_PORT/${PORT:-8000}/" /etc/nginx/sites-available/default

# Arrancar php-fpm en background
php-fpm -D

# Esperar que php-fpm arranque
sleep 2

# Arrancar nginx en foreground
nginx -g 'daemon off;'