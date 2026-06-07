#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
echo "--- which php-fpm ---"
which php-fpm || echo "php-fpm binary not found on PATH"
echo "--- php-fpm config test ---"
php-fpm -y /assets/php-fpm.conf -t
echo "--- starting php-fpm ---"
php-fpm -y /assets/php-fpm.conf -D > /tmp/php-fpm-out.log 2>&1
sleep 1
if pgrep -x php-fpm > /dev/null; then
  echo "php-fpm is running"
else
  echo "php-fpm FAILED to start -- output:"
  cat /tmp/php-fpm-out.log
fi
nginx -c /app/nginx.conf
