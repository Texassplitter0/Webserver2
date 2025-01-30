
FROM php:8.1-apache
COPY . /var/www/html/
COPY ./Webserver-main /var/www/html/Webserver-main/
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN a2enmod rewrite
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/Webserver-main\n\
    <Directory /var/www/html/Webserver-main>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install mysqli
