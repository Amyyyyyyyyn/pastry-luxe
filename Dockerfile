FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip gnupg \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node + build assets
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

# IMPORTANT: fix Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

# 🚀 SAFE runtime optimization (NOT build time)
CMD sh -c "php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000"

EXPOSE 10000