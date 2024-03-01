FROM php:8.2-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y git curl libpq-dev libpng-dev libonig-dev libxml2-dev zip unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN apt-get update && apt-get install -y supervisor && \
    mkdir -p /var/log/supervisor

ADD . /var/www/html

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html/users

USER $user
