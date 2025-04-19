# Use an official PHP image as the base image
FROM php:7.4-apache

# Install PHP extensions and packages required for your project
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Enable Apache mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the project files into the container
COPY . /var/www/html/

# Create PHPMailer directory if it doesn't exist
RUN mkdir -p /var/www/html/PHPMailer

# Download PHPMailer files directly
RUN curl -o /var/www/html/PHPMailer/PHPMailer.php https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/PHPMailer.php \
    && curl -o /var/www/html/PHPMailer/SMTP.php https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/SMTP.php \
    && curl -o /var/www/html/PHPMailer/Exception.php https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/Exception.php

# Set the correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose the port Apache is running on
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]