# Deployment Guide - Niagahoster

Panduan lengkap untuk deploy aplikasi **Arsip Digital USBR** ke Niagahoster.

## Persiapan Awal

### 1. Database Setup

1. Masuk ke **cPanel** hosting Anda
2. Buka **phpMyAdmin**
3. Buat database baru:
   - Database Name: `arsip_digital_usbr`
   - Collation: `utf8mb4_unicode_ci`
4. Buat user database:
   - Username: `arsip_user`
   - Password: `[password_yang_kuat]`
5. Assign user ke database dengan ALL PRIVILEGES

### 2. Upload via FTP/File Manager

**Opsi A: Menggunakan FTP**

1. Download FTP Client (FileZilla, WinSCP, dll)
2. Koneksi ke server:
   - Host: ftp.yourdomain.com
   - Username: cPanel username
   - Password: cPanel password
   - Port: 21

3. Upload file ke folder `public_html` atau subdomain folder

**Opsi B: Menggunakan cPanel File Manager**

1. Masuk cPanel → File Manager
2. Navigasi ke `public_html`
3. Upload file dalam bentuk ZIP
4. Extract di folder yang diinginkan

## Installation Steps

### 1. Persiapan File

```bash
# Buat folder project
mkdir arsip-digital
cd arsip-digital

# Clone repository
git clone https://github.com/kampususbr/arsipdigitalv1.git .
```

### 2. Install Dependencies

```bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Install NPM dependencies
npm install

# Build assets
npm run build
```

### 3. Konfigurasi Environment

```bash
# Copy .env file
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

Edit `.env` dengan kredensial database:

```env
APP_NAME="Arsip Digital USBR"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=arsip_digital_usbr
DB_USERNAME=arsip_user
DB_PASSWORD=password_anda

MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Arsip Digital USBR"
```

### 4. Setup Storage & Cache

```bash
# Create storage directories
mkdir -p storage/app/documents
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set permissions (via SSH)
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

### 5. Database Migration

```bash
# Run migrations
php artisan migrate --force

# Seed default data
php artisan db:seed
```

### 6. Create Storage Symlink

```bash
# Create symlink untuk public storage
php artisan storage:link
```

## Optimisasi Production

### 1. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Queue Setup (Opsional)

Jika menggunakan queue untuk email:

```bash
# Setup cron job di cPanel untuk queue
* * * * * cd /path/to/arsip-digital && php artisan schedule:run >> /dev/null 2>&1
```

### 3. SSL Certificate

- Gunakan **AutoSSL** di cPanel
- Atau request manual SSL installation
- Update `APP_URL` ke `https://yourdomain.com`

## Testing

Setelah deployment:

1. Akses aplikasi: `https://yourdomain.com`
2. Login dengan credentials default:
   - Email: `admin@usbr.ac.id`
   - Password: `password`

3. Test fitur utama:
   - Upload dokumen
   - Manajemen user
   - Dashboard analytics

## Troubleshooting

### Error 500 - Internal Server Error

```bash
# Check error logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan view:clear
```

### Permission Denied

```bash
# Fix permissions
chmod -R 755 storage bootstrap/cache
chown -R nobody:nobody storage bootstrap/cache
```

### Database Connection Error

- Verifikasi database credentials di `.env`
- Test connection via phpMyAdmin
- Pastikan MySQL service running di server

### File Upload Not Working

```bash
# Check upload_tmp_dir setting
php -i | grep upload_tmp_dir

# Create tmp directory
mkdir -p /tmp/php-uploads
chmod 777 /tmp/php-uploads
```

## Maintenance

### Regular Backups

1. Database backup via phpMyAdmin
2. File backup via cPanel → Backup
3. Automasi backup menggunakan script cron

### Update Dependencies

```bash
# Check for updates
composer outdated

# Update safely
composer update --no-dev
npm update
npm run build
```

### Monitor Performance

- Monitor error logs regularly
- Check disk space usage
- Monitor database size
- Review activity logs dalam aplikasi

## Support

Untuk bantuan lebih lanjut:
- Hubungi support Niagahoster
- Check Laravel documentation: https://laravel.com/docs
- Repository issues: https://github.com/kampususbr/arsipdigitalv1/issues
