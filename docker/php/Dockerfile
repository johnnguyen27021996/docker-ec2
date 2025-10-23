FROM php:8.3-fpm

# Cài các thư viện cần thiết cho mongodb và PHP extensions
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    unzip \
    zip \
    git \
    libonig-dev \
    libxml2-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo mbstring xml \
    && rm -rf /var/lib/apt/lists/*

# Cài composer (copy từ official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini /usr/local/etc/php/

# Cài Supervisor
RUN apt-get update && apt-get install -y supervisor

# Tạo thư mục log
RUN mkdir -p /var/log/supervisor
RUN chown -R www-data:www-data /var/log/supervisor
RUN chmod -R 775 /var/log/supervisor

# Copy file cấu hình Supervisor
COPY docker/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/php/php-worker.conf /etc/supervisor/conf.d/php-worker.conf

# Cài nginx
RUN apt-get update && apt-get install -y nginx

ARG APP_ENV=local
ENV APP_ENV=${APP_ENV}
RUN mkdir -p /etc/nginx/conf.d
COPY docker/nginx/default.conf.local /etc/nginx/conf.d/default.conf.local
COPY docker/nginx/default.conf.dev /etc/nginx/conf.d/default.conf.dev
COPY docker/nginx/default.conf.prd /etc/nginx/conf.d/default.conf.prd

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

ENTRYPOINT ["/entrypoint.sh"]
