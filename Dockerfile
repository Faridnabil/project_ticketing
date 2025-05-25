# ========== STAGE 1: BUILD DEPENDENCIES ==========
FROM php:8.2-cli as builder

# Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Copy env template (opsional, hanya jika ingin auto generate APP_KEY saat build, tapi tidak disarankan untuk production)
RUN if [ -f laravel.env ]; then cp laravel.env .env; fi

# ========== STAGE 2: FINAL IMAGE ==========
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy app & composer from builder
COPY --from=builder /var/www/html /var/www/html
COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer

# Expose the Laravel development port
EXPOSE 9008

# Default command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9008"]