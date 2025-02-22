# Use an official PHP image as the base image
FROM php:7.4-apache

# Install PHP extensions required for your project (if needed)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for URL rewriting (if necessary)
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the project files into the container, including the CSS folder
COPY . /var/www/html/

# Set the correct permissions (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose the port Apache is running on
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
