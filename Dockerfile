FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql
COPY index.php /var/www/html/