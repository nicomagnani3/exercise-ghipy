#!/bin/bash



FIRST_RUN=false
if [ ! -f .env ]; then
    FIRST_RUN=true
    cp .env.example .env
    sleep 1
    php artisan key:generate
fi
php artisan down
php artisan optimize:clear
php artisan db mysql
php artisan migrate 
php artisan db:seed 
php artisan optimize
php artisan storage:link
php artisan up

php-fpm
