
FROM php:8.1-apache
COPY ./Webserver-main /var/www/html/
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN a2enmod rewrite
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted
RUN docker-php-ext-install mysqli
