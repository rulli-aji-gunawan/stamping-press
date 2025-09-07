#!/bin/bash

echo "🚀 Starting deployment script..."

# Set environment for production
export APP_ENV=production
export APP_DEBUG=false

echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "🗄️ Running database migrations..."
php artisan migrate --force --no-interaction

echo "🎯 Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🎨 Building frontend assets..."
if [ -f "package.json" ]; then
    npm ci --only=production
    npm run build
else
    echo "No package.json found, skipping npm build"
fi

echo "✅ Deployment completed successfully!"
