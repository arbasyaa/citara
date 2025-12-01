#!/bin/bash
# Deployment Script for Citara Project
# Run this after uploading files to production server

set -e  # Exit on error

echo "🚀 Starting Citara Deployment..."

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${RED}❌ Error: .env file not found!${NC}"
    echo "Copy .env.production.example to .env and configure it first"
    exit 1
fi

# Check if APP_ENV is production
APP_ENV=$(grep APP_ENV .env | cut -d '=' -f2)
if [ "$APP_ENV" != "production" ]; then
    echo -e "${YELLOW}⚠️  Warning: APP_ENV is not set to 'production'${NC}"
    read -p "Continue anyway? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Check if APP_DEBUG is false
APP_DEBUG=$(grep APP_DEBUG .env | cut -d '=' -f2)
if [ "$APP_DEBUG" != "false" ]; then
    echo -e "${RED}❌ Error: APP_DEBUG must be false in production!${NC}"
    exit 1
fi

echo -e "${GREEN}✓${NC} Environment checks passed"

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installing Node dependencies..."
npm ci

# Build assets
echo "🔨 Building frontend assets..."
npm run build

# Database migrations
echo "💾 Running database migrations..."
php artisan migrate --force

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache optimization
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chmod 644 .env

# Create storage link if not exists
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Run optimizations
echo "⚡ Running additional optimizations..."
php artisan optimize

echo ""
echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo ""
echo "📋 Post-deployment checklist:"
echo "  1. Verify database connection"
echo "  2. Test admin login at /panel/login"
echo "  3. Check website at homepage"
echo "  4. Monitor error logs: storage/logs/laravel.log"
echo "  5. Verify HTTPS is working"
echo "  6. Test file uploads"
echo ""
echo -e "${YELLOW}⚠️  Remember to:${NC}"
echo "  - Setup automated backups"
echo "  - Configure cron for scheduled tasks"
echo "  - Setup SSL certificate (Let's Encrypt)"
echo "  - Enable HTTPS redirect in .htaccess"
echo ""
