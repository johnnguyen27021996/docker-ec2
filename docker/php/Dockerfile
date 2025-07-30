FROM php:8.3-fpm

# Cài các thư viện cần thiết cho mongodb và PHP extensions
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    unzip \
    git \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Cài pecl mongodb extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Cài các PHP extension thường dùng (thay đổi tuỳ dự án)
RUN docker-php-ext-install pdo mbstring xml

# Cài composer (copy từ official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/

WORKDIR /var/www/html

# Copy code (tuỳ bạn, nếu dùng volume thì bỏ bước này)
COPY . .

# Cài dependencies composer
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]

EXPOSE 8080
