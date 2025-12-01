# 🔒 SECURITY FIXES - MANDATORY BEFORE DEPLOYMENT

## ⚠️ CRITICAL - DO IMMEDIATELY

### 1. Remove .env from Git History
```bash
# Remove .env from git
git rm --cached .env
git commit -m "security: Remove .env from repository"

# Optional: Clean git history (if .env was committed before)
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch .env" \
  --prune-empty --tag-name-filter cat -- --all

# Force push (BE CAREFUL - coordinate with team)
# git push origin --force --all
```

### 2. Generate New Secrets
```bash
# Generate new APP_KEY
php artisan key:generate

# Change ALL passwords in database
# Change DB_PASSWORD in production .env
```

### 3. Add Rate Limiting to Routes
Create file: `app/Http/Middleware/ThrottleRequests.php` or use Laravel's built-in

**Update routes/web.php:**
```php
// Add to login route
Route::post('/panel/login', [AdminController::class, 'login'])
    ->middleware('throttle:5,1') // 5 attempts per minute
    ->name('panel.login.post');

// Add to all admin routes
Route::prefix('panel')->middleware(['throttle:60,1'])->group(function () {
    // ... existing routes
});
```

### 4. Enable Session Encryption
**Update .env for production:**
```env
SESSION_ENCRYPT=true
SESSION_DRIVER=database
SESSION_LIFETIME=30  # 30 minutes for admin
```

### 5. Add HTTPS Enforcement
**Update public/.htaccess (add after RewriteEngine On):**
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Add HSTS Header
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
```

### 6. Add Security Headers
**Update public/.htaccess:**
```apache
<IfModule mod_headers.c>
    # Existing headers...
    
    # Content Security Policy
    Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'"
    
    # Prevent clickjacking
    Header always set X-Frame-Options "DENY"
    
    # Prevent MIME type sniffing
    Header always set X-Content-Type-Options "nosniff"
    
    # Enable XSS Protection
    Header always set X-XSS-Protection "1; mode=block"
    
    # Referrer Policy
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    
    # Permissions Policy (formerly Feature Policy)
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"
</IfModule>
```

---

## 🛡️ HIGH PRIORITY

### 7. Add Input Validation & Sanitization
**Update AdminController.php methods:**
```php
use Illuminate\Support\Str;

// Add to all store/update methods
$data = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string|max:5000',
    // ... other fields
]);

// Sanitize HTML inputs
if (isset($data['description'])) {
    $data['description'] = Str::limit(strip_tags($data['description'], '<p><br><strong><em>'), 5000);
}
```

### 8. Add Admin Activity Logging
Create new migration:
```bash
php artisan make:migration create_admin_logs_table
```

```php
Schema::create('admin_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('action');
    $table->string('model')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();
    $table->json('changes')->nullable();
    $table->string('ip_address', 45);
    $table->string('user_agent')->nullable();
    $table->timestamps();
    
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->index(['user_id', 'created_at']);
});
```

### 9. Add Password Policy
**Update app/Models/User.php:**
```php
use Illuminate\Validation\Rules\Password;

// In registration/update validation
'password' => ['required', 'confirmed', Password::min(8)
    ->mixedCase()
    ->numbers()
    ->symbols()
    ->uncompromised()],
```

### 10. Protect Against Mass Assignment
**Review ALL models - ensure $fillable or $guarded is set:**
```php
// ✅ GOOD - Explicitly listed
protected $fillable = ['nama', 'slug', 'deskripsi'];

// ❌ BAD - Too permissive
protected $guarded = [];
```

---

## 🔐 MEDIUM PRIORITY

### 11. Add CSRF Token Verification Check
All forms already have `@csrf` - GOOD ✅
But verify in middleware that it's enforced.

### 12. Database Security
**Production .env must have:**
```env
DB_CONNECTION=mysql
DB_HOST=localhost  # NOT publicly accessible
DB_PORT=3306
DB_DATABASE=citara_production
DB_USERNAME=citara_user  # NOT root
DB_PASSWORD=ComplexP@ssw0rd!2024  # Strong password
```

### 13. File Upload Security
**Update AdminController.php:**
```php
// Add to image upload validation
'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',

// After upload, validate image
if ($request->hasFile('image')) {
    $file = $request->file('image');
    
    // Validate actual image
    $imageInfo = getimagesize($file->path());
    if (!$imageInfo) {
        return back()->withErrors(['image' => 'File is not a valid image']);
    }
    
    // Generate unique filename to prevent overwrite
    $filename = uniqid() . '_' . time() . '.' . $file->extension();
    $path = $file->storeAs('uploads', $filename, 'public');
    $data['image'] = $path;
}
```

### 14. Add Environment Check
**Update app/Providers/AppServiceProvider.php:**
```php
public function boot()
{
    // Force HTTPS in production
    if ($this->app->environment('production')) {
        \URL::forceScheme('https');
        
        // Disable debug mode
        if (config('app.debug')) {
            throw new \Exception('Debug mode MUST be disabled in production!');
        }
    }
}
```

### 15. Add Backup Strategy
```bash
# Install Laravel Backup
composer require spatie/laravel-backup

# Configure daily database + files backup
# Add to .env
BACKUP_DRIVER=s3  # or local
```

---

## 📊 MONITORING & LOGGING

### 16. Setup Error Monitoring
**Recommended:** Install Sentry or similar
```bash
composer require sentry/sentry-laravel
```

### 17. Enable Query Logging (Development Only)
**config/database.php:**
```php
'mysql' => [
    // ...
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
    'dump' => [
        'use_single_transaction',
    ],
],
```

---

## ✅ DEPLOYMENT CHECKLIST

Before going live, verify:

- [ ] .env removed from git
- [ ] New APP_KEY generated
- [ ] All passwords changed
- [ ] Rate limiting enabled
- [ ] Session encryption ON
- [ ] HTTPS enforced
- [ ] Security headers added
- [ ] Input validation on all forms
- [ ] File upload validation
- [ ] Admin logging implemented
- [ ] Database backups configured
- [ ] Error monitoring setup
- [ ] APP_DEBUG=false
- [ ] APP_ENV=production
- [ ] Cache driver = redis/memcached
- [ ] Queue driver = database/redis
- [ ] Run: `composer install --no-dev --optimize-autoloader`
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Run: `npm run build`
- [ ] Test all functionality on staging first

---

## 🚨 AFTER DEPLOYMENT - CONTINUOUS SECURITY

1. **Regular Updates**
   ```bash
   composer update  # Monthly security updates
   npm update       # Keep dependencies current
   ```

2. **Monitor Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Run Security Audits**
   ```bash
   composer audit
   npm audit
   ```

4. **Database Backups**
   - Daily automated backups
   - Test restoration quarterly

5. **SSL Certificate**
   - Use Let's Encrypt (free)
   - Auto-renewal setup

---

**IMPORTANT:** Don't skip these security fixes. A compromised system costs more than prevention.
