FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev \
    supervisor nginx \
    nodejs npm cifs-utils

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

# Copy nginx and supervisor configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.prod.conf /etc/supervisor/conf.d/supervisord.conf

# Expose HTTP port
EXPOSE 80

CMD ["/usr/bin/supervisord"]
