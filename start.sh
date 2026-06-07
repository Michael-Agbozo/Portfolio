#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
find / -name "php-fpm.conf" 2>/dev/null
php-fpm -y /assets/php-fpm.conf -D
sleep 1
pgrep -x php-fpm > /dev/null && echo "php-fpm is running" || echo "php-fpm FAILED to start"
nginx -c /app/nginx.conf
