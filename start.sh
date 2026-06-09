#!/bin/bash
mkdir -p /var/log/nginx
chmod -R 777 /app/storage /app/bootstrap/cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan storage:link --force 2>/dev/null || true
php-fpm -y /assets/php-fpm.conf -D
node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf

# Let the dashboard accept the same 50 MB image uploads Laravel validates.
# Replace a smaller generated value if one exists; otherwise add it.
if grep -q "client_max_body_size" /nginx.conf; then
    sed -i 's/client_max_body_size[[:space:]][^;]*;/client_max_body_size 64M;/' /nginx.conf
else
    sed -i 's|charset utf-8;|charset utf-8;\n        client_max_body_size 64M;|' /nginx.conf
fi

# Inject Laravel routing if missing
if ! grep -q "try_files" /nginx.conf; then
    sed -i 's|charset utf-8;|charset utf-8;\n\n        location / {\n            try_files $uri $uri/ /index.php?$query_string;\n        }|' /nginx.conf
fi

nginx -c /nginx.conf
