# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Arguments
ARG NODE_VERSION=21.7.2  

# Install system dependencies
RUN apt update && apt install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    supervisor cron gnupg ca-certificates

# Clean up unnecessary files
RUN apt clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install NVM and Node.js (Persistent)
RUN curl -fsSL https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash && \
    export NVM_DIR="$HOME/.nvm" && \
    . "$NVM_DIR/nvm.sh" && \
    nvm install $NODE_VERSION && \
    nvm use $NODE_VERSION && \
    nvm alias default $NODE_VERSION && \
    ln -sf $NVM_DIR/versions/node/v$NODE_VERSION/bin/node /usr/local/bin/node && \
    ln -sf $NVM_DIR/versions/node/v$NODE_VERSION/bin/npm /usr/local/bin/npm && \
    ln -sf $NVM_DIR/versions/node/v$NODE_VERSION/bin/npx /usr/local/bin/npx

# Set working directory
WORKDIR /var/www

# Copy Laravel app and force ownership
COPY --chown=www-data:www-data . /var/www

# Fix storage and cache permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Switch to www-data user
USER www-data

# Install frontend dependencies
RUN npm install --force && npm run dev

EXPOSE 80

CMD ["php-fpm"]
