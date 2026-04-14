FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip libpq-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN cp .env.example .env
RUN php artisan key:generate

# Cache config (optional but good)
RUN php artisan config:cache || true
RUN php artisan route:cache || true

CMD php artisan serve --host=0.0.0.0 --port=10000