# Stage 1: Composer dependencies
FROM composer:2 AS build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader
COPY . .

# Stage 2: PHP + Nginx container
FROM php:8.2-fpm

# Install dependencies and Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Copy Laravel app from build stage
WORKDIR /var/www
COPY --from=build /app ./

# Copy Nginx config
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Set correct permissions
RUN chown -R www-data:www-data /var/www

# Expose port 80 (Nginx)
EXPOSE 80

# Start Nginx and PHP-FPM together
CMD service nginx start && php-fpm
