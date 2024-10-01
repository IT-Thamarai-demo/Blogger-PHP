# Use an official PHP runtime as a parent image
FROM php:8.0-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/

# Install necessary extensions for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache when the container starts
CMD ["apache2-foreground"]
