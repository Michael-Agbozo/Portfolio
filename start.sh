#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php-fpm -y /assets/php-fpm.conf -D
nginx -c /app/nginx.conf
