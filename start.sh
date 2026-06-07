#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
rm -f /nginx.conf
node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf
nginx -c /nginx.conf
