FROM php:8.1-fpm

# Sistem paketleri
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Composer kur
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Proje dosyalarını kopyala
COPY . .

# İzinler (zorunlu)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache