# ---------------------------------------------
# Base PHP Image
# ---------------------------------------------
FROM php:8.2-fpm

# Install System Dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Laravel Optimizations
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# Ensure proper folder permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port expected by Render
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000