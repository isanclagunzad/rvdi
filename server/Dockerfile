# Use an official PHP image as the base
FROM php:7.4-apache

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    mariadb-server \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel application
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ensure correct permissions for the storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Add a custom Apache configuration file to enable .htaccess rewrites
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start MariaDB and create the database
RUN service mysql start && \
    mysql -e "CREATE DATABASE rvdi_hr_db;"

# Set environment variables for Laravel
ENV DB_CONNECTION=mysql
ENV DB_HOST=127.0.0.1
ENV DB_PORT=3306
ENV DB_DATABASE=rvdi_hr_db
ENV DB_USERNAME=root
ENV DB_PASSWORD=

# Run Composer db:reset command
RUN composer db:reset

# Start Apache and MariaDB in the foreground
CMD service mysql start && apache2-foreground
