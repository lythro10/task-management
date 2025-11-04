FROM php:8.3-fpm-alpine

# System deps
RUN apk add --no-cache \
    bash git curl zip unzip icu-dev oniguruma-dev libzip-dev \
    libpng-dev freetype-dev libjpeg-turbo-dev $PHPIZE_DEPS

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo_mysql bcmath intl gd zip opcache

# Redis extension (optional but handy)
RUN pecl install redis \
 && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Fixes write permissions
RUN set -eux; \
    mkdir -p storage/framework/{cache,data,sessions,testing,views} \
             bootstrap/cache \
             vendor; \
    chown -R www-data:www-data storage bootstrap/cache vendor; \
    chmod -R ug+rwX storage bootstrap/cache vendor