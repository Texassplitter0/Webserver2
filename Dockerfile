
FROM php:8.1-apache

# Copy project files into the container
COPY ./Webserver-main /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Enable required modules and set DirectoryIndex
RUN a2enmod rewrite

# Add DirectoryIndex for welcome.html
RUN echo '<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
DirectoryIndex welcome.html' > /etc/apache2/conf-enabled/custom.conf

# Install MySQL extension
RUN docker-php-ext-install mysqli
