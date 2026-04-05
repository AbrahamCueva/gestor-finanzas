FROM php:8.3-cli

# Instalar extensiones
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libxml2-dev libonig-dev libexif-dev \
    libicu-dev libbcmath-ocaml-dev nodejs npm \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring xml curl zip \
    gd bcmath exif intl opcache fileinfo

# Instalar Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build
RUN php artisan storage:link

EXPOSE 8000

CMD php artisan migrate --force && \
    php artisan optimize && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}