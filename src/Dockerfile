# Use the official PHP image with Apache
FROM php:8.0-apache

# Copy your application code to the Apache root directory
COPY . /var/www/html/

# Install any additional PHP extensions your app needs
# For example, uncomment the following to add MySQL support:
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html

# Make sure permissions are set correctly
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
