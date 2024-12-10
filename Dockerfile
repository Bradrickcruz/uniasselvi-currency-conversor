FROM php:8.3-apache
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y libsqlite3-dev sqlite3 && docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html
EXPOSE 80

RUN php init_db.php
CMD ["apache2-foreground"]
