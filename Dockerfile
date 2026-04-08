FROM php:8.2-apache

# Устанавливаем системные зависимости и расширение PDO SQLite
RUN apt-get update && apt-get install -y \
        sqlite3 \
        libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && apt-get clean

# Включаем mod_rewrite для Apache (опционально, но часто нужно для ЧПУ)
RUN a2enmod rewrite

# Копируем все файлы проекта в рабочую директорию Apache
COPY . /var/www/html/

# (Опционально) Устанавливаем права на запись для SQLite, если база будет создаваться внутри контейнера
# RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80 (стандартный для Apache)
EXPOSE 80