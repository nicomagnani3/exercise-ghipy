#!/bin/bash

cd /var/www/html

composer install

php artisan down
php artisan optimize:clear
php artisan db mysql
php artisan migrate --force
php artisan db:seed --force
php artisan optimize
rm public/storage
php artisan storage:link
php artisan up

php-fpm
