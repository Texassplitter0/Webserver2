FROM php:8.1-apache
COPY ./Webserver-main /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli
