FROM php:8.3-apache

SHELL ["/bin/bash", "-o", "pipefail", "-c"]

RUN set -eux; \
  apt-get update; \
  apt-get install -y --no-install-recommends \
    git unzip pkg-config libonig-dev libzip-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
    libicu-dev libxml2-dev \
  ; \
  docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp; \
  docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring zip bcmath gd intl; \
  a2enmod rewrite headers; \
  rm -rf /var/lib/apt/lists/*

# Composer per si vols ús puntual
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP de dev
COPY docker/web/php-dev.ini /usr/local/etc/php/conf.d/php-dev.ini
