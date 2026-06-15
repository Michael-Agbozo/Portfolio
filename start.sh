#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true

# Increase PHP upload limits
echo "upload_max_filesize=50M" > /tmp/uploads.ini
echo "post_max_size=50M" >> /tmp/uploads.ini
export PHP_INI_SCAN_DIR=/tmp

php-fpm -y /assets/php-fpm.conf -D

# php-fpm -D starts PHP in the background and returns immediately, before
# PHP is actually ready to handle requests. If nginx starts first, every
# request gets a 500 until PHP catches up. Wait for PHP-FPM's socket/port
# to come up (max ~10s) before continuing.
for i in $(seq 1 50); do
    if pgrep -x php-fpm > /dev/null 2>&1 && \
       { [ -S /run/php/php-fpm.sock ] || (echo > /dev/tcp/127.0.0.1/9000) 2>/dev/null; }; then
        break
    fi
    sleep 0.2
done

node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf

# Inject Laravel routing if missing
if ! grep -q "try_files" /nginx.conf; then
    sed -i 's|charset utf-8;|charset utf-8;\n\n        location / {\n            try_files $uri $uri/ /index.php?$query_string;\n        }|' /nginx.conf
fi

nginx -c /nginx.conf
