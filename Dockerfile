FROM php:8.4-fpm

ARG user=paulo
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libmcrypt-dev \
    libssl-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    openssl 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# RUN pecl install xdebug-3.4.0beta1
# RUN docker-php-ext-enable xdebug

# # Configure Xdebug
# RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.mode=develop,coverage,debug,gcstats,profile,trace" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.log=/var/www/html/xdebug/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/error_reporting.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
RUN useradd -m -d /home/paulo -s /bin/bash paulo
RUN chown -R paulo:paulo /var/www

USER paulo