#!/bin/bash

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Creating storage link..."
php artisan storage:link --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache

echo "Build complete!"
