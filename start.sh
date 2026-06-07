#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
echo "--- php-fpm.conf contents ---"
cat /assets/php-fpm.conf
echo "--- starting php-fpm ---"
php-fpm -y /assets/php-fpm.conf -D > /tmp/php-fpm-out.log 2>&1
sleep 2
echo "--- matching processes ---"
ps aux | grep -i fpm | grep -v grep
echo "--- captured output ---"
cat /tmp/php-fpm-out.log
nginx -c /app/nginx.conf
