# Arsip Digital USBR

Sistem manajemen arsip digital berbasis web untuk Universitas Swadharma Bandung Raya (USBR).

## Fitur Utama

- 🔐 **Multi-Level User Authentication** - Admin, Manager, User Biasa, Viewer
- 📁 **Manajemen Dokumen** - Upload, edit, hapus dokumen PDF (max 5MB)
- 🏷️ **Kategori Dinamis** - Master data untuk kategori dokumen dan unit kerja
- 🔍 **Search & Filter** - Pencarian dokumen berdasarkan kategori, tanggal, pembuat
- 📊 **Dashboard Infografis** - Statistik dokumen, aktivitas user, storage usage
- 📥 **Upload Dokumen** - Support file PDF dengan validasi ukuran dan format
- 👥 **User Management** - Manajemen user dengan role-based access control
- 📋 **Activity Log** - Tracking semua aktivitas user dalam sistem

## Tech Stack

- **Backend:** Laravel 10
- **Frontend:** Bootstrap 5, HTML5, CSS3
- **Database:** MySQL
- **File Storage:** Local Server Storage
- **Server:** PHP 8.1+ (Compatible with Niagahoster)

## Installation

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js & NPM (untuk development)

### Setup Local Development

1. Clone repository
```bash
git clone https://github.com/kampususbr/arsipdigitalv1.git
cd arsipdigitalv1
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_digital_usbr
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations & seeding
```bash
php artisan migrate
php artisan db:seed
```

6. Start development server
```bash
php artisan serve
npm run dev
```

Akses aplikasi di `http://localhost:8000`

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@usbr.ac.id | password |
| Manager | manager@usbr.ac.id | password |
| User | user@usbr.ac.id | password |
| Viewer | viewer@usbr.ac.id | password |

## Deployment ke Niagahoster

### Via cPanel

1. Upload project via FTP ke folder `public_html` atau subdomain
2. Upload database melalui phpMyAdmin
3. Update konfigurasi `.env` sesuai server Niagahoster
4. Run migrations:
   ```bash
   php artisan migrate --force
   ```

### Via Terminal/SSH

```bash
cd /home/user/public_html
git clone https://github.com/kampususbr/arsipdigitalv1.git .
composer install --no-dev
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed
chmod -R 775 storage bootstrap/cache
```

## Project Structure

```
arsipdigitalv1/
├── app/
│   ├── Models/               # Database models
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/       # Custom middleware
│   └── Traits/               # Reusable traits
├── database/
│   ├── migrations/           # Database migrations
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   └── api.php               # API routes
├── storage/
│   └── documents/            # Upload dokumen
└── public/
    └── storage/              # Symlink untuk public storage
```

## User Roles & Permissions

### Admin
- Kelola semua dokumen
- Kelola user account
- Akses master data
- Lihat semua laporan

### Manager
- Kelola dokumen di kategori tertentu
- Lihat laporan
- Buat user biasa

### User Biasa
- Upload dokumen
- Edit dokumen milik sendiri
- Lihat dokumen sesuai akses

### Viewer
- Lihat dokumen
- Download dokumen
- Tidak bisa upload/edit

## License

MIT License - lihat file LICENSE untuk detail.

## Support

Untuk bantuan, silakan hubungi tim development atau buat issue di GitHub.

---

**Developed for USBR** | Last Updated: 2026
