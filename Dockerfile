FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libxml2-dev libonig-dev libexif-dev \
    libicu-dev \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring xml zip \
    gd bcmath exif intl opcache

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app
COPY . .

RUN mkdir -p storage/framework/cache \
             storage/framework/sessions \
             storage/framework/views \
             storage/framework/testing \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Crear .env mínimo solo para el build
RUN echo "APP_KEY=base64:tmpkeyfortmpfortmpfortmpfortmpfortmpfort=" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "CACHE_DRIVER=array" >> .env \
    && echo "DB_CONNECTION=mysql" >> .env

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

RUN npm ci && npm run build
RUN php artisan storage:link

# Limpiar el .env temporal, el real viene de Railway en runtime
RUN rm .env

EXPOSE 8000

CMD php artisan migrate --force && \
    php artisan optimize && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}