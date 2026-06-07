#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
find / -name "fastcgi_params" 2>/dev/null
php-fpm -y /assets/php-fpm.conf -D
nginx -c /app/nginx.conf
