# =========================
# Stage 1 - Composer (PHP backend)
# =========================
FROM composer:2.6 as composer-deps

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# =========================
# Stage 2 - Node/Vite (Frontend)
# =========================
FROM node:18-alpine as node-build

WORKDIR /app

# Copy everything (backend + frontend)
COPY . .

# Copy vendor from composer stage (for Ziggy etc.)
COPY --from=composer-deps /app/vendor ./vendor

# Install node modules and build assets
RUN npm install && npm run build

# =========================
# Stage 3 - Final (Nginx + PHP-FPM)
# =========================
FROM php:8.2-fpm-alpine

# Required extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install dependencies
RUN apk add --no-cache nginx bash curl supervisor

WORKDIR /var/www/html

# Copy built app from previous stage
COPY --from=node-build /app ./

# Copy nginx config
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Laravel permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose ports
EXPOSE 80

# Start services (nginx and php-fpm)
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
