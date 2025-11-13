#!/bin/bash

# Production Deployment Optimization Script
# Run this script before deploying to production

echo "🚀 Starting production optimization..."

# 1. Clear all caches
echo "📦 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Optimize configuration
echo "⚙️  Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Build optimized frontend assets
echo "🎨 Building production assets..."
npm run build

# 4. Optimize Composer autoloader
echo "📚 Optimizing Composer autoloader..."
composer install --optimize-autoloader --no-dev

# 5. Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage/logs

# 6. Create symbolic link for storage (if not exists)
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage symbolic link..."
    php artisan storage:link
fi

echo "✅ Production optimization complete!"
echo ""
echo "📋 Post-deployment checklist:"
echo "   - Ensure APP_ENV=production in .env"
echo "   - Ensure APP_DEBUG=false in .env"
echo "   - Verify database connection"
echo "   - Test asset loading (CSS/JS)"
echo "   - Check image uploads work"
echo ""
