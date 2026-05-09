FROM php:8.4-cli

# Install git, unzip, and zip extension (required for composer)
RUN apt-get update && apt-get install -y git unzip libzip-dev faketime libfaketime ncat psmisc && rm -rf /var/lib/apt/lists/*

# Configure git safe directory (needed when mounting source from host)
RUN git config --global --add safe.directory /app

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && mkdir -p /usr/local/etc/php/conf.d/docker/php-ext-xdebug.ini

# Copy Xdebug configuration
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy dependency files first for better caching
COPY composer.json composer.lock* ./

# Install dependencies (including dev tools)
# Use composer update to get latest versions matching composer.json constraints
RUN composer update --optimize-autoloader

# Copy application code
COPY . .

# Create cache directories
RUN mkdir -p var/cache rector/var/cache .phpunit.cache

# Default command
CMD ["tail", "-f", "/dev/null"]
