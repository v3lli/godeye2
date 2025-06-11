# Stage 1: Build assets with Node
FROM node:18-alpine as frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 2: Setup PHP environment
FROM php:8.2-fpm-alpine as backend

# Install dependencies
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    git \
    zip \
    unzip \
    libpng \
    libpng-dev \
    libjpeg \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    icu-dev \
    libxml2-dev \
    oniguruma-dev \
    zlib-dev \
    libzip-dev \
    sqlite

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create app directory
WORKDIR /var/www/html

# Copy application source
COPY . .

# Copy built assets
COPY --from=frontend /app/public /var/www/html/public

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html/storage

# Laravel setup
RUN cp .env.example .env \
 && php artisan key:generate \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Nginx config
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Expose ports
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
