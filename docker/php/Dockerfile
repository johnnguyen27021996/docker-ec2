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

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chmod -R 777 /var/www/html/storage

RUN php artisan key:generate

CMD ["php-fpm"]

RUN apt-get update && apt-get install -y supervisor

COPY docker/php/supervisord.conf /etc/supervisor/cond.f/supervisord.conf

RUN mkdir -p /var/log/supervisor

RUN chmod -R 777 /var/log/supervisor

CMD ["/usr/bin/supervisord", "-n", "/etc/supervisor/cond.f/supervisord.conf"]