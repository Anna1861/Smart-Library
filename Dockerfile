FROM php:8.2-cli

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Копируем проект
COPY . .

# Установка зависимостей Laravel
RUN composer install

# Открываем порт
EXPOSE 10000

# Запуск Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
