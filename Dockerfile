FROM php:8.2-apache

# Устанавливаем SQLite3 и расширение PDO SQLite
RUN docker-php-ext-install pdo_sqlite

# Копируем все файлы сайта в директорию Apache
COPY . /var/www/html/

# Включаем mod_rewrite (если нужен)
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Открываем порт 80
EXPOSE 80