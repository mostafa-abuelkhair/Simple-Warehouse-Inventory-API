FROM php:8.2-fpm

# system dependencies and build tools for PECL extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    gcc \
    make \
    autoconf \
    pkg-config \
    libssl-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy application files
COPY . /var/www/html

# set permissions for Laravel
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache || true

# install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

EXPOSE 9000
CMD ["php-fpm"]

