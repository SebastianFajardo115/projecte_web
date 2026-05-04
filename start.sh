#!/bin/bash

cd /var/www/html/laravel

echo "DB_URL: $DB_URL"
echo "DB_HOST: $DB_HOST"

php artisan config:clear
php artisan migrate --force || echo "Migration failed, continuing..."

apache2-foreground
