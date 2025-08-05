FROM php:8.2-apache

ENV MOODLE_VERSION=5.0 \
    MOODLE_DIR=/var/www/html

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libxml2-dev \
    libonig-dev libssl-dev unzip zip git curl vim pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pgsql \
        pdo_pgsql \
        zip \
        xml \
        intl \
        soap \
        mbstring \
        opcache \
        exif \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy custom config files
COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

EXPOSE 80

WORKDIR ${MOODLE_DIR}

CMD ["apache2-foreground"]
