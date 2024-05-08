#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --working-dir=/var/www/html
npm install --prefix /var/www/html



echo "generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache
php artisan route:clear

echo "php artisan optimize..."
php artisan optimize

echo "Running migrations..."
php artisan migrate --force

#echo "Running seeders..."
#php artisan db:seed --force
