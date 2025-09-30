FROM php:8.2-cli

# Install system dependencies needed for Symfony + mbstring
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git unzip libonig-dev \
    && docker-php-ext-install mbstring \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/library_management_system_web

# Copy composer files first (for caching)
COPY composer.json composer.lock ./

RUN composer install --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy full project
COPY . .

# Optimize autoload
RUN composer dump-autoload --optimize

# Make var/ writable
RUN mkdir -p var && chown -R www-data:www-data var

# Expose port for built-in server
EXPOSE 8001

# Start Symfony built-in server
CMD ["php", "-S", "0.0.0.0:8001", "-t", "public"]
