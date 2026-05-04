#!/bin/bash

# Fix Apache MPM conflict
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

cd /var/www/html/laravel

php artisan config:clear
php artisan migrate --force || echo "Migration failed, continuing..."

apache2-foreground
