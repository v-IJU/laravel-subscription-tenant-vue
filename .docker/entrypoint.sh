#!/bin/bash
set -e

echo "Running migrations and seeders..."

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."


# Run Laravel commands
php artisan migrate --force
php artisan cms-migrate
php artisan db:cms-seed
php artisan db:seed --class=DomainConfigurationSeeder
php artisan update:cms-module
php artisan update:cms-plugins
php artisan update:cms-menu

echo "CMS setup completed successfully!"

# Start PHP-FPM
exec "$@"
