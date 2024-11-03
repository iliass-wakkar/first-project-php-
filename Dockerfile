# Use an official PHP image with Apache
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install necessary extensions and dependencies
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Copy the content of the 'src' directory into the container's working directory
COPY src/ /var/www/html/

# Expose port 80 to allow external access to the service
EXPOSE 80

# Update Apache configuration to serve files from the root directory
RUN echo "DocumentRoot /var/www/html" > /etc/apache2/sites-available/000-default.conf

# Enable Apache rewrite module (optional, useful if you use URL rewriting in your PHP app)
RUN a2enmod rewrite

# Start Apache in the foreground
CMD ["apache2-foreground"]
