#!/bin/bash
set -e

cd /var/www/html/laravel

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

apache2-foreground
