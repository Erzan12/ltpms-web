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

# Clear and rebuild config using Render env vars
RUN php artisan config:clear && \
    php artisan cache:clear

# Start app + run migrations
CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=10000