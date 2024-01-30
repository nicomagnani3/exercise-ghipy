#!/bin/bash

service mysql start
mysql --password=root -e 'create database IF NOT EXISTS interaction_gifs;' -v
mysql --password=root -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';"
mysql --password=root -e 'GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost';'

FIRST_RUN=false
if [ ! -f .env ]; then
    FIRST_RUN=true
    cp .env.example .env
    sleep 1
fi
php artisan key:generate
php artisan optimize:clear
php artisan optimize
php artisan config:cache
php artisan up

php-fpm
