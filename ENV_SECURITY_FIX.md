# 🔐 URGENT: .env FILE SECURITY

## ⚠️ CRITICAL ISSUE DETECTED

File `.env` dengan credentials database terdeteksi dalam git repository.

## 📋 IMMEDIATE ACTIONS REQUIRED

### 1. Remove .env from Git (DO THIS NOW!)

```bash
# Remove .env from git tracking
git rm --cached .env
git commit -m "security: Remove .env from repository"

# Push changes
git push origin frontend
```

### 2. Generate New APP_KEY

```bash
# This will update your .env file with new key
php artisan key:generate
```

### 3. Change Database Password

1. Login ke MySQL:
```bash
mysql -u root -p
```

2. Change password:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'NEW_STRONG_PASSWORD_HERE';
FLUSH PRIVILEGES;
EXIT;
```

3. Update .env:
```env
DB_PASSWORD=NEW_STRONG_PASSWORD_HERE
```

### 4. Create Non-Root Database User (RECOMMENDED)

```sql
-- Login as root
mysql -u root -p

-- Create dedicated user
CREATE USER 'citara_user'@'localhost' IDENTIFIED BY 'StrongP@ssw0rd123!';

-- Grant permissions only to citara database
GRANT ALL PRIVILEGES ON citara.* TO 'citara_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Update .env:
```env
DB_USERNAME=citara_user
DB_PASSWORD=StrongP@ssw0rd123!
```

### 5. Verify .gitignore

Ensure .env is in .gitignore (already done ✅):
```
.env
.env.backup
.env.production
```

### 6. For Production Server

When deploying:
1. Copy .env.production.example to .env
2. Fill all values with production credentials
3. NEVER commit .env to git
4. Set proper file permissions: `chmod 600 .env`

## 🔍 Check if .env Was Already Committed

```bash
# Check git history
git log --all --full-history -- .env

# If found in history, you may want to clean it:
# WARNING: This rewrites git history!
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch .env" \
  --prune-empty --tag-name-filter cat -- --all

# Force push (coordinate with team first!)
git push origin --force --all
```

## ✅ Verification Checklist

After completing above steps:

- [ ] .env removed from git
- [ ] New APP_KEY generated
- [ ] Database password changed
- [ ] Non-root DB user created
- [ ] .env has correct permissions (600)
- [ ] Tested database connection works
- [ ] Application still works
- [ ] Notified team about changes

## 🚨 NEVER DO THIS AGAIN

**Rules to prevent future issues:**

1. NEVER `git add .env`
2. ALWAYS use .env.example for sharing config structure
3. Use environment variables for CI/CD
4. Use secrets management in production (Vault, AWS Secrets Manager, etc.)
5. Review git status before committing

## 📞 Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Test database: `php artisan tinker` → `DB::connection()->getPdo();`
3. Clear caches: `php artisan config:clear && php artisan cache:clear`

---

**Status:** INCOMPLETE - Complete these steps before production deployment!
