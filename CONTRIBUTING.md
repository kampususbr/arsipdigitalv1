# KONTRIBUSI & PENGEMBANGAN

## Setup Development Environment

### Requirements
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL 5.7+
- Git

### Installation

```bash
# Clone repository
git clone https://github.com/kampususbr/arsipdigitalv1.git
cd arsipdigitalv1

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev

# Start development server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Code Structure

### Directory Layout

```
arsipdigitalv1/
├── app/
│   ├── Models/              # Database models
│   ├── Http/
│   │   ├── Controllers/     # Web controllers
│   │   ├── Middleware/      # Custom middleware
│   │   └── Requests/        # Form requests (validation)
│   ├── Traits/              # Reusable traits
│   └── Policies/            # Authorization policies
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories (testing)
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
├── storage/
│   └── app/documents/       # Uploaded documents
├── config/                  # Configuration files
└── tests/                   # Unit & Feature tests
```

## Development Workflow

### 1. Membuat Feature Baru

```bash
# Create new branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "feat: add new feature"

# Push to repository
git push origin feature/new-feature

# Create Pull Request
```

### 2. Database Changes

```bash
# Create new migration
php artisan make:migration create_table_name

# Create new seeder
php artisan make:seeder TableNameSeeder

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback
```

### 3. Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TestName

# With coverage
php artisan test --coverage
```

## Coding Standards

### PSR-12 PHP Style Guide

```php
// Good
class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        return User::create($validated);
    }
}

// Bad
class usercontroller extends controller
{
    public function store($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->save();
        return $user;
    }
}
```

### Naming Conventions

- **Classes**: PascalCase (UserController)
- **Methods**: camelCase (storeDocument)
- **Variables**: snake_case ($total_documents)
- **Constants**: UPPER_SNAKE_CASE (MAX_UPLOAD_SIZE)
- **Database tables**: plural snake_case (documents)
- **Database columns**: snake_case (created_by)

## Git Commit Messages

Gunakan conventional commits:

```
feat: add document sharing feature
fix: resolve upload permission issue
refactor: simplify authentication logic
docs: update deployment guide
test: add unit tests for DocumentController
chore: update dependencies
```

## Performance Optimization

### Database Queries

```php
// Use eager loading
$documents = Document::with('category', 'creator')->get();

// Use select untuk batasi columns
$documents = Document::select('id', 'title', 'category_id')->get();

// Use pagination
$documents = Document::paginate(15);
```

### Caching

```php
// Cache query results
$categories = Cache::remember('categories', 3600, function () {
    return DocumentCategory::active()->get();
});
```

### Asset Optimization

```bash
# Minify CSS & JS
npm run build

# Optimize images
php artisan image:optimize
```

## Documentation

### PHPDoc Comments

```php
/**
 * Store a newly created document in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    // ...
}
```

### README Updates

Update README.md ketika:
- Menambah fitur baru
- Mengubah instalasi steps
- Menambah dependencies baru
- Mengubah struktur database

## Troubleshooting Development

### Cache Issues

```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### Database Issues

```bash
# Reset database
php artisan migrate:refresh
php artisan migrate:refresh --seed

# Seed specific table
php artisan db:seed --class=UserSeeder
```

### Asset Issues

```bash
# Rebuild assets
npm run dev

# Watch for changes
npm run watch
```

## Deployment Pipeline

1. **Development** (Local)
   - Write & test code
   - Commit to feature branch

2. **Testing** (CI/CD)
   - Automated tests run
   - Code style checks
   - Security scanning

3. **Staging** (Pre-production)
   - Deploy to staging server
   - Manual testing
   - Performance testing

4. **Production** (Live)
   - Deploy to Niagahoster
   - Monitor performance
   - Track logs

## Support & Resources

- **Laravel Docs**: https://laravel.com/docs
- **Laravel Best Practices**: https://github.com/alexeymezenin/laravel-best-practices
- **PHP PSR Standards**: https://www.php-fig.org/psr/
- **GitHub Issues**: https://github.com/kampususbr/arsipdigitalv1/issues

## License

MIT License - lihat file LICENSE untuk detail.
