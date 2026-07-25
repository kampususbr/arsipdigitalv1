# DEPLOYMENT CHECKLIST - Arsip Digital USBR untuk Niagahoster

## ✅ Pre-Deployment Checklist

### Server Requirements
- [ ] PHP 8.1+ (verify at cPanel → Select PHP Version)
- [ ] MySQL 5.7+ (available di Niagahoster)
- [ ] Composer installed
- [ ] Node.js & NPM available
- [ ] SSH Access enabled

### Repository Configuration
- [ ] Clone latest code from main branch
- [ ] Check all files are in place (composer.json, package.json, etc)
- [ ] Verify `.env.example` exists
- [ ] Verify database migrations exist in `database/migrations/`
- [ ] Verify seeders exist in `database/seeders/`

### Environment Setup
- [ ] Copy `.env.example` to `.env`
- [ ] Generate `APP_KEY` with `php artisan key:generate`
- [ ] Update database credentials:
  - DB_HOST: localhost
  - DB_PORT: 3306
  - DB_DATABASE: arsip_digital_usbr
  - DB_USERNAME: arsip_user
  - DB_PASSWORD: [strong password]
- [ ] Update APP_URL to HTTPS domain
- [ ] Set APP_DEBUG=false
- [ ] Set LOG_LEVEL=error

### Dependency Installation
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm install`
- [ ] Run `npm run build`

### Storage & Permissions
- [ ] Create storage directories:
  - [ ] storage/app/documents
  - [ ] storage/framework/cache
  - [ ] storage/framework/sessions
  - [ ] storage/framework/views
  - [ ] storage/logs
- [ ] Set permissions:
  - [ ] chmod -R 755 storage/
  - [ ] chmod -R 755 bootstrap/cache/
  - [ ] chmod 644 .env
  - [ ] chmod 755 public/

### Database Setup
- [ ] Create database via phpMyAdmin
- [ ] Create database user with ALL PRIVILEGES
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed`
- [ ] Run `php artisan storage:link`

### Production Optimization
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan cache:clear` (if needed)

### SSL & Security
- [ ] Install SSL via AutoSSL (cPanel)
- [ ] Verify APP_URL uses HTTPS
- [ ] Update MAIL_FROM_ADDRESS
- [ ] Set secure cookies in production

### Testing
- [ ] Access https://yourdomain.com in browser
- [ ] Login with admin@usbr.ac.id / password
- [ ] Test upload document (PDF)
- [ ] Test download document
- [ ] Check dashboard
- [ ] Create new user
- [ ] Verify storage permissions by uploading file

### Monitoring & Logs
- [ ] Check `storage/logs/laravel.log` for errors
- [ ] Verify no 500 errors
- [ ] Check file upload working
- [ ] Monitor cPanel for disk usage

### Cron Jobs (Optional)
- [ ] Setup cron for Laravel scheduler:
  ```
  * * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
  ```

---

## 📦 Files Provided

### Configuration Files
- ✅ `.htaccess` - URL routing for Laravel
- ✅ `.env.production` - Production environment template
- ✅ `.user.ini` - PHP configuration for uploads

### Documentation
- ✅ `NIAGAHOSTER_SETUP.md` - Complete 8-step setup guide
- ✅ `DEPLOYMENT_CHECKLIST.md` - This file
- ✅ `README.md` - Application documentation

### Scripts
- ✅ `QUICK_DEPLOY.sh` - Automated deployment script
- ✅ `verify-setup.php` - Setup verification tool

---

## 🚀 Quick Deployment Steps

### Step 1: SSH into Server
```bash
ssh username@yourdomain.com
cd public_html
```

### Step 2: Clone Repository
```bash
git clone https://github.com/kampususbr/arsipdigitalv1.git .
```

### Step 3: Run Quick Deploy (Recommended)
```bash
chmod +x QUICK_DEPLOY.sh
bash QUICK_DEPLOY.sh
```

### Step 4: Manual Configuration
```bash
# Edit .env with your credentials
nano .env

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed

# Create symlink
php artisan storage:link
```

### Step 5: Verify Setup
```bash
php verify-setup.php
```

### Step 6: Test Application
```bash
# Visit https://yourdomain.com
# Login and test features
```

---

## 🔍 Verification Commands

```bash
# Check PHP version
php -v

# Check required extensions
php -m

# Check storage permissions
ls -la storage/

# Check bootstrap cache permissions
ls -la bootstrap/

# Check .env file
ls -la | grep .env

# Check error logs
tail -50 storage/logs/laravel.log

# Check database connection
php artisan tinker
>>> DB::connection()->getPDO();

# List all routes
php artisan route:list

# Check config is cached
php artisan config:list
```

---

## ⚠️ Common Issues & Solutions

### Issue: 500 Error
**Solution:**
```bash
tail -50 storage/logs/laravel.log
php artisan cache:clear
php artisan config:clear
php artisan config:cache
```

### Issue: Permission Denied
**Solution:**
```bash
chmod -R 755 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache
```

### Issue: Database Connection Error
**Solution:**
1. Verify credentials in `.env`
2. Test in phpMyAdmin
3. Ensure database user has ALL PRIVILEGES
4. Run: `php artisan cache:clear`

### Issue: File Upload Not Working
**Solution:**
```bash
mkdir -p storage/app/documents
chmod 777 storage/app/documents
php -i | grep upload_max_filesize
```

### Issue: CSS/JS Not Loading
**Solution:**
```bash
npm run build
php artisan view:cache
php artisan cache:clear
```

---

## 📋 Maintenance Schedule

### Daily
- Monitor error logs: `tail -f storage/logs/laravel.log`
- Check disk usage in cPanel

### Weekly
- Backup database via phpMyAdmin
- Backup files via cPanel Backup

### Monthly
- Review access logs
- Update security patches
- Test disaster recovery

### Quarterly
- Review & update dependencies
- Performance optimization review

---

## 📞 Support Resources

- **Niagahoster Help:** https://www.niagahoster.co.id/blog
- **Laravel Docs:** https://laravel.com/docs/10.x
- **Project Issues:** https://github.com/kampususbr/arsipdigitalv1/issues

---

**Last Updated:** 2026-07-25
**Version:** 1.0.0
