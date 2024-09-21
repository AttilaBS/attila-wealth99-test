# Use the official PHP 7.3 image
FROM php:7.3-fpm

ARG user=app
ARG uid=1000

# Install required extensions
RUN apt-get update && apt-get install -y \
    sudo \
    libfreetype6-dev \
    libonig-dev \
    vim \
    git \
    unzip \
    curl \
    libssl-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY .env.example /var/www/html

RUN mv /var/www/html/.env.example /var/www/html/.env

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

# Copy current application code to the container
COPY . .

# Set ownership and permissions for the storage directory
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 755 /var/www/html/storage

USER $user
