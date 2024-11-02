# Use an official PHP image with Apache
FROM php:8.1-apache

# Set the working directory inside the container to /var/www/html/homepage
WORKDIR /var/www/html/homepage

# Copy the content of the 'homepage' directory into the container's working directory
COPY homepage/ /var/www/html/homepage

# Expose port 80 to allow external access to the service
EXPOSE 80

# Update Apache configuration to serve files from the 'homepage' directory
RUN echo "DocumentRoot /var/www/html/homepage" > /etc/apache2/sites-available/000-default.conf

# Enable Apache rewrite module (optional, useful if you use URL rewriting in your PHP app)
RUN a2enmod rewrite

# Start Apache in the foreground
CMD ["apache2-foreground"]
