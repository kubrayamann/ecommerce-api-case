# Laravel için PHP 8.1-FPM kullanıyoruz
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Composer kurulumunu yapıyoruz
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Proje dosyalarını kopyala
COPY . .

# Bağımlılıkları kur
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# .env dosyasını oluştur
RUN cp .env.example .env

# Storage ve cache izinleri
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
