# --------- Stage 1: Build Vite frontend ----------
FROM node:18 AS node_builder
WORKDIR /app

# copy only package files for caching
COPY package*.json vite.config.js ./
RUN npm ci

# copy laravel frontend resources
COPY resources ./resources

# build assets
RUN npm run build

# --------- Stage 2: PHP runtime ----------
FROM php:8.2-fpm

# install system packages + php extensions
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev curl gnupg ca-certificates procps \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd zip exif pdo pdo_mysql bcmath sockets \
  && rm -rf /var/lib/apt/lists/*

# copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# app code
WORKDIR /var/www/html
COPY . .

# copy vite build output
COPY --from=node_builder /app/public/build ./public/build

# install php dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# expose port for Railway
EXPOSE 8080

# start laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
