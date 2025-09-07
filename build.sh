#!/bin/bash

echo "Starting build process..."

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Clear and cache Laravel configurations
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run database migrations
php artisan migrate --force

# Cache configurations for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install and build frontend assets
npm ci
npm run build

echo "Build completed successfully!"
