#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true
php-fpm -y /assets/php-fpm.conf -D
node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf

# Inject Laravel routing if missing
if ! grep -q "try_files" /nginx.conf; then
    sed -i 's|charset utf-8;|charset utf-8;\n\n        location / {\n            try_files $uri $uri/ /index.php?$query_string;\n        }|' /nginx.conf
fi

nginx -c /nginx.conf
