FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev \
    libxml2-dev libonig-dev libexif-dev \
    libicu-dev nginx \
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
    && chmod -R 777 storage bootstrap/cache /tmp

RUN echo "APP_KEY=base64:tmpkeyfortmpfortmpfortmpfortmpfortmpfort=" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "CACHE_DRIVER=array" >> .env \
    && echo "DB_CONNECTION=mysql" >> .env

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
RUN npm ci && npm run build
RUN php artisan filament:assets
RUN php artisan storage:link
RUN rm .env

RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "sys_temp_dir=/tmp" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_tmp_dir=/tmp" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting=E_ALL & ~E_NOTICE & ~E_DEPRECATED" >> /usr/local/etc/php/conf.d/custom.ini

# Nginx config
RUN printf 'server {\n\
    listen RAILWAY_PORT;\n\
    root /app/public;\n\
    index index.php;\n\
    client_max_body_size 100M;\n\
    location / { try_files $uri $uri/ /index.php?$query_string; }\n\
    location ~ \\.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        fastcgi_read_timeout 300;\n\
        fastcgi_send_timeout 300;\n\
        include fastcgi_params;\n\
    }\n\
}\n' > /etc/nginx/sites-available/default

COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000

CMD ["/start.sh"]