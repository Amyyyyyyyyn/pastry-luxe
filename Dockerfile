FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Install frontend dependencies + build
RUN npm install && npm run build

# Fix Laravel permissions (IMPORTANT)
RUN chmod -R 775 storage bootstrap/cache

# Optimize Laravel for production
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port (Render will override anyway)
EXPOSE 10000

# Start Laravel (IMPORTANT: use Render PORT)
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
