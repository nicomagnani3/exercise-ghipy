FROM php:8.2-fpm

ARG user
ARG uid

RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev
RUN apt clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY .docker/php-fpm.conf /usr/local/etc/php-fpm.d/iutrace.conf
RUN sed -i "s/user = www-data/user = $user/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = $user/g" /usr/local/etc/php-fpm.d/www.conf
    

WORKDIR /var/www

USER $user
COPY --chown=$user:$user . .

EXPOSE 9000
ENTRYPOINT [".docker/init.sh"]