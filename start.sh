#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php-fpm -y /assets/php-fpm.conf -D 2>/tmp/php-fpm-error.log
sleep 1
if pgrep -x php-fpm > /dev/null; then
  echo "php-fpm is running"
else
  echo "php-fpm FAILED to start -- error output:"
  cat /tmp/php-fpm-error.log
fi
nginx -c /app/nginx.conf
