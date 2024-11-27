FROM php:8.3-apache
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
