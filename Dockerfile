
FROM php:8.1-apache
COPY ./Webserver-main /var/www/html/
RUN docker-php-ext-install mysqli
