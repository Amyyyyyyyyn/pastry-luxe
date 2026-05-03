FROM php:8.2-fpm

# =========================
# System dependencies
# =========================
RUN apt-get update && apt-get install -y \
    git curl unzip zip gnupg \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# =========================
# Composer
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================
# Node.js (CLEAN INSTALL - NO NODE SOURCE SCRIPT)
# =========================
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /usr/share/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/nodesource.gpg] https://deb.nodesource.com/node_22.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs

# =========================
# Workdir
# =========================
WORKDIR /var/www

# =========================
# Copy dependency files first (CACHE OPTIMIZATION)
# =========================
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# =========================
# Install PHP dependencies
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# Install Node dependencies
# =========================
RUN npm install

# =========================
# Copy full project AFTER install
# =========================
COPY . .

# =========================
# Build Vite assets
# =========================
RUN npm run build

# =========================
# Permissions (Laravel fix)
# =========================
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# =========================
# Port
# =========================
EXPOSE 10000

# =========================
# Start Laravel
# =========================
CMD php artisan serve --host=0.0.0.0 --port=10000