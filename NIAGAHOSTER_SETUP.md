# Setup Lengkap Arsip Digital USBR di Niagahoster

## Tahap 1: Persiapan di cPanel

### 1.1 Buat Database
1. Login ke cPanel
2. Buka **phpMyAdmin**
3. Klik **New** di sidebar
4. Buat database:
   - **Database Name:** `arsip_digital_usbr`
   - **Collation:** `utf8mb4_unicode_ci`
   - Klik **Create**

### 1.2 Buat Database User
1. Di cPanel, buka **MySQL Databases**
2. Scroll ke "Add New User"
3. Username: `arsip_user` (atau custom)
4. Password: gunakan password generator (minimal 12 karakter)
5. Create User
6. Kembali ke "Add User to Database"
7. Select user `arsip_user` dan database `arsip_digital_usbr`
8. Berikan **ALL PRIVILEGES**
9. Make changes

## Tahap 2: Upload via Git (Recommended)

### 2.1 Setup SSH Access
1. Di cPanel, buka **SSH Access**
2. Klik **Manage SSH Keys**
3. Generate key atau upload public key
4. Authorize key

### 2.2 Clone Repository
```bash
# Login via SSH
ssh username@yourdomain.com

# Navigate ke public_html
cd public_html

# Remove existing files if any
rm -rf *

# Clone repository
git clone https://github.com/kampususbr/arsipdigitalv1.git .
```

### 2.3 Install Dependencies
```bash
# Install Composer
composer install --no-dev --optimize-autoloader

# Install NPM
npm install

# Build Frontend Assets
npm run build
```

## Tahap 3: Konfigurasi Environment

### 3.1 Setup .env File
```bash
# Copy env file
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

### 3.2 Edit .env dengan Credentials
```bash
# Edit dengan nano atau vi
nano .env
```

Update nilai berikut:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=arsip_digital_usbr
DB_USERNAME=arsip_user
DB_PASSWORD=password_yang_dibuat_tadi

MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

## Tahap 4: Setup Storage & Permissions

```bash
# Create storage directories
mkdir -p storage/app/documents
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
chmod 755 public
```

## Tahap 5: Database Setup

```bash
# Run migrations
php artisan migrate --force

# Seed default data (users, permissions, etc)
php artisan db:seed

# Create storage symlink
php artisan storage:link
```

## Tahap 6: Optimasi Production

```bash
# Cache configuration untuk performa lebih baik
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear yang lama jika ada
php artisan cache:clear
```

## Tahap 7: SSL Certificate (HTTPS)

1. Di cPanel, buka **AutoSSL**
2. Klik tombol untuk install SSL
3. Tunggu beberapa menit sampai selesai
4. Update `.env`:
   ```env
   APP_URL=https://yourdomain.com
   ```
5. Re-cache:
   ```bash
   php artisan config:cache
   ```

## Tahap 8: Setup Cron Job (Optional)

Untuk queue dan scheduled tasks:

1. Di cPanel, buka **Cron Jobs**
2. Add New Cron Job:
   - Common Settings: **Once Per Minute**
   - Command:
   ```
   cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
   ```
3. Add Cron Job

## Testing & Verification

### Test Akses
1. Buka browser: `https://yourdomain.com`
2. Seharusnya redirect ke dashboard atau login page
3. Login dengan credentials:
   - Email: `admin@usbr.ac.id`
   - Password: `password`

### Test Fitur Utama
1. Upload dokumen PDF
2. Download dokumen
3. Buat user baru
4. Cek dashboard analytics

### Check Error Logs
```bash
# Lihat error log
tail -f storage/logs/laravel.log
```

## Troubleshooting

### Error 500 - Internal Server Error
```bash
# Check error log
tail -50 storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Permission Denied
```bash
# Re-set permissions
chmod -R 755 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache
```

### Database Connection Error
1. Verifikasi credentials di `.env` sudah benar
2. Test koneksi via phpMyAdmin
3. Pastikan database user punya privileges

### File Upload Tidak Bekerja
```bash
# Check upload settings
php -i | grep upload_max_filesize

# Buat upload tmp directory
mkdir -p /tmp/php-uploads
chmod 777 /tmp/php-uploads
```

### Assets (CSS/JS) Tidak Load
```bash
# Re-build assets
npm run build

# Clear cache
php artisan view:clear
```

## Maintenance

### Regular Backups
1. Database: Gunakan phpMyAdmin > Export
2. Files: Via cPanel > Backup
3. Schedule: Tiap minggu minimal

### Monitor Performance
1. Check `storage/logs/laravel.log` secara berkala
2. Monitor disk usage di cPanel
3. Monitor database size
4. Review aktivitas user di aplikasi

### Update Dependencies (Hati-hati!)
```bash
# Check untuk update
composer outdated

# Update dengan testing
composer update --no-dev
npm update
npm run build

# Test aplikasi sebelum push ke production
```

## Useful Commands Reference

```bash
# Laravel Commands
php artisan tinker                    # Interactive shell
php artisan migrate:refresh          # Reset & re-migrate
php artisan db:seed --class=UserSeeder  # Seed specific
php artisan queue:work               # Start queue worker

# Useful Info
php -v                               # Check PHP version
php -m                               # List loaded modules
php -i                               # Full PHP info

# File Management
ls -la                               # List files with permissions
du -sh *                             # Check directory sizes
du -sh storage/                      # Check storage size
```

## Support & Documentasi

- Laravel Docs: https://laravel.com/docs/10.x
- Niagahoster Docs: https://www.niagahoster.co.id/blog
- Repository Issues: https://github.com/kampususbr/arsipdigitalv1/issues

---

**Setup by:** GitHub Copilot
**Last Updated:** 2026-07-25