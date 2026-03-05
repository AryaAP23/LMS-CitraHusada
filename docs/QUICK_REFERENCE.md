# Quick Reference & FAQ - LMS Citra Husada Backend

## Quick Reference

### Artisan Commands Sering Digunakan

```bash
# Development
php artisan serve                    # Start dev server
php artisan tinker                   # Interactive shell

# Database
php artisan migrate                  # Run migrations
php artisan migrate:rollback         # Rollback migrate
php artisan db:seed                  # Run seeders
php artisan db:seed --class=RoleSeeder  # Run specific seeder

# Cache
php artisan cache:clear              # Clear cache
php artisan config:cache             # Cache config
php artisan view:clear               # Clear view cache
php artisan route:cache              # Cache routes

# Session
php artisan session:table            # Create session table
php artisan session:clear            # Clear all sessions

# Generate
php artisan make:model User -m       # Create Model + Migration
php artisan make:controller UserController  # Create Controller
php artisan make:migration create_users_table  # Create Migration
php artisan make:seeder UserSeeder   # Create Seeder

# Testing
php artisan test                     # Run tests
php artisan test --coverage          # With coverage

# Routes
php artisan route:list               # List all routes
php artisan route:list --path=api    # Filter routes
```

### NPM Commands

```bash
# Development
npm install                          # Install dependencies
npm run dev                          # Development with watch
npm run build                        # Production build

# Specific assets
npm run hot                          # Hot reload (if setup)
```

### HTTP Methods Cheatsheet

```
GET    /api/jenis-tenaga              → List all
GET    /api/jenis-tenaga/1            → Get detail
POST   /api/jenis-tenaga              → Create new
PUT    /api/jenis-tenaga/1            → Update
DELETE /api/jenis-tenaga/1            → Delete
```

### Database Connection Test

```bash
# Test MySQL connection
mysql -u root -p lms_citra_husada

# List all databases
SHOW DATABASES;

# List tables
USE lms_citra_husada;
SHOW TABLES;

# Check user data
SELECT user_id, nama, nik FROM users LIMIT 5;
```

---

## Frequently Asked Questions (FAQ)

### Setup & Installation

#### Q: Bagaimana cara setup project dari awal?
**A:** Ikuti langkah-langkah di `docs/DOKUMENTASI_BACKEND.md` - Setup Development section. Pastikan MySQL, PHP 8.2, dan Composer sudah terinstall.

```bash
git clone https://github.com/AryaAP23/LMS-CitraHusada.git
cd LMS-CitraHusada
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

#### Q: Database creation gagal, gimana?
**A:** Pastikan MySQL service berjalan, lalu buat database manual:
```bash
mysql -u root -e "CREATE DATABASE lms_citra_husada CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Q: Kalau .env file tidak ada?
**A:** Copy dari .env.example:
```bash
cp .env.example .env
php artisan key:generate
```

---

### Authentication & Session

#### Q: Login gagal "User belum login", apa masalahnya?
**A:** Kemungkinan alasan:
1. Session middleware belum jalan - check `bootstrap/app.php`
2. Cookie tidak dikirim - pastikan Axios config punya `withCredentials: true`
3. Database migration belum jalan - jalankan `php artisan migrate`

Solusi:
```php
// bootstrap/app.php
$middleware->api(prepend: [
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
]);
```

```javascript
// resources/js/bootstrap.js
window.axios.defaults.withCredentials = true;
```

#### Q: Apa itu "remember me" di login?
**A:** Fitur untuk memperpanjang session lifetime. Session normal 120 menit, dengan remember me bisa lebih lama. Di backend:
```php
Auth::attempt($credentials, $request->boolean('remember'));
```

#### Q: Bagaimana cara clear semua sessions?
**A:** Run command:
```bash
php artisan session:clear
```

Atau dari MySQL:
```sql
DELETE FROM sessions;
```

---

### Models & Database

#### Q: Bagaimana cara create model baru dengan migration?
**A:** Gunakan artisan command:
```bash
php artisan make:model Materi -m
# Ini akan buat:
# - app/Models/Materi.php
# - database/migrations/YYYY_MM_DD_create_materis_table.php
```

#### Q: Bagaimana cara define relationships di Model?
**A:** Lihat contoh di `docs/DATABASE_SCHEMA.md` atau:
```php
// One-to-Many
public function subMateris() {
    return $this->hasMany(SubMateri::class, 'materi_id');
}

// Belongs To
public function materi() {
    return $this->belongsTo(Materi::class, 'materi_id');
}

// Many-to-Many
public function jenisTenagas() {
    return $this->belongsToMany(JenisTenaga::class, 'materi_jenis_tenagas');
}
```

#### Q1: Apa perbedaan migration `php artisan migrate` vs manual SQL?
**A:** Migration lebih baik karena:
- Version control friendly
- Reversible (bisa rollback)
- Konsisten di semua environment
- Dokumentasi otomatis

#### Q: Bagaimana cara rollback migration terakhir?
**A:** 
```bash
php artisan migrate:rollback
```

Untuk rollback beberapa steps:
```bash
php artisan migrate:rollback --step=3
```

---

### APIs & Controllers

#### Q: Bagaimana format JSON response yang standar?
**A:** Gunakan format ini:
```json
{
    "success": true,
    "message": "Success message",
    "data": { /* response data */ }
}
```

#### Q: Bagaimana cara handle validation errors?
**A:** 
```php
$request->validate([
    'nik'      => 'required|string|unique:users',
    'password' => 'required|min:3',
]);
```

Jika error, response otomatis:
```json
{
    "message": "Validation failed",
    "errors": {
        "nik": ["NIK field is required"],
        "password": ["Password must be at least 3 characters"]
    }
}
```

#### Q: Bagaimana cara require authentication di route?
**A:** Gunakan middleware `auth`:
```php
Route::middleware('auth')->group(function () {
    Route::post('/jenis-tenaga', [JenisTenagaController::class, 'store']);
});
```

#### Q: Bagaimana test API endpoint?
**A:** Gunakan cURL, Postman, atau REST Client extension:

cURL:
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"nik":"0112.01072","password":"123"}' \
  -c cookies.txt
```

VS Code REST Client (`test.http`):
```http
POST http://127.0.0.1:8000/api/login
Content-Type: application/json

{
    "nik": "0112.01072",
    "password": "123"
}
```

---

### Middleware & Routing

#### Q: Apa bedanya route di `routes/api.php` vs `routes/web.php`?
**A:** 
- **api.php** - JSON API routes, biasanya return JSON
- **web.php** - Web routes, return HTML views, form-based
- **api.php** tidak ada CSRF protection secara default
- **api.php** rate-limited per default

#### Q: Bagaimana cara buat custom middleware?
**A:** 
```bash
php artisan make:middleware CheckAdmin
```

Kemudian register di `bootstrap/app.php`:
```php
$middleware->web(append: [
    \App\Http\Middleware\CheckAdmin::class,
]);
```

#### Q: Bagaimana cara debug route?
**A:** 
```bash
php artisan route:list
php artisan route:list --path=api
php artisan route:list -v  # Show more details
```

---

### Performance & Optimization

#### Q: Bagaimana cara optimize database queries?
**A:** Gunakan eager loading untuk avoid N+1:
```php
// Good - Eager load relationships
$users = User::with('role', 'jenisTenaga', 'unitKerja')->get();

// Bad - N+1 problem
$users = User::all();
foreach ($users as $user) {
    echo $user->role->role; // Query setiap loop!
}
```

#### Q: Bagaimana cara cache data?
**A:** Gunakan Laravel cache:
```php
// Store in cache for 1 hour
$roles = Cache::remember('roles', 3600, function () {
    return Role::all();
});

// Clear cache
Cache::forget('roles');
Cache::flush(); // Clear semua cache
```

#### Q: Bagaimana cara index database untuk performa?
**A:** Di migration:
```php
$table->index('nik');                // Regular index
$table->unique('email');             // Unique index
$table->foreign('role_id')->on('roles')->references('role_id');  // Foreign key
```

---

### Security

#### Q: Bagaimana cara hash password dengan aman?
**A:** Gunakan Laravel Hash facade:
```php
$password = Hash::make($plainPassword);

// Verify
if (Hash::check($inputPassword, $hashedPassword)) {
    // Password match
}
```

#### Q: Bagaimana cara protect API dari unauthorized access?
**A:** Gunakan middleware `auth`:
```php
Route::middleware('auth')->post('/users', [UserController::class, 'store']);
```

Atau check manually:
```php
if (!auth()->check()) {
    return response()->json(['error' => 'Unauthorized'], 401);
}
```

#### Q: Bagaimana cara prevent SQL injection?
**A:** Selalu gunakan query builder atau Eloquent, bukan raw SQL:
```php
// Good - Eloquent
$user = User::where('nik', $nik)->first();

// Good - Query Builder
$user = DB::table('users')->where('nik', $nik)->first();

// Bad - Raw SQL
$user = DB::select("SELECT * FROM users WHERE nik = '$nik'");
```

#### Q: Bagaimana cara implement CSRF protection?
**A:** Di form Blade:
```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

Untuk API, token di header:
```javascript
// bootstrap.js auto-set ini
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
```

---

### Troubleshooting

#### Q: "SQLSTATE[HY000] [2002] Connection refused"
**A:** Database connection error:
1. Pastikan MySQL service berjalan
2. Check `.env` credentials
3. Pastikan database sudah dibuat
```bash
mysql -u root -e "SHOW DATABASES;" | grep lms_citra
```

#### Q: "Class not found" error
**A:** Clear autoloader cache:
```bash
composer dump-autoload
```

#### Q: Assets tidak ter-load di browser
**A:** Rebuild assets:
```bash
npm run build
php artisan config:cache
```

#### Q: Table doesn't exist error
**A:** Run migrations:
```bash
php artisan migrate
php artisan migrate:status  # Check status
```

#### Q: "Trying to access array offset on value of type null"
**A:** Check jika data exist sebelum akses:
```php
// Bad
echo $user->profile['name'];

// Good
if (isset($user->profile) && isset($user->profile['name'])) {
    echo $user->profile['name'];
}

// Or use null safe operator (PHP 8.0+)
echo $user->profile?->name;
```

---

### Development Tips

#### Q: Bagaimana cara speed up development?
**A:** 
1. Gunakan `npm run dev` untuk watch assets
2. Gunakan `php artisan tinker` untuk test code
3. Setup cache dengan `php artisan config:cache`
4. Use Laravel Telescope untuk debugging (optional)

#### Q: Bagaimana best practice untuk variable naming?
**A:**
```php
// Database columns: snake_case
// Table name: plural snake_case
// PHP variables/methods: camelCase
// Constants: UPPER_SNAKE_CASE
// Classes: PascalCase

// ✅ Good
class UserController {
    public function getUserProfile() {
        $user_name = $user->user_name;  // database
        $userName = $user->user_name;   // PHP variable
    }
}

// ❌ Bad
class user_controller {
    public function get_user_profile() { }
}
```

#### Q: Bagaimana cara maintain code quality?
**A:** Gunakan Laravel Pint untuk code formatting:
```bash
composer require laravel/pint --dev
./vendor/bin/pint

# Check without fixing
./vendor/bin/pint --test
```

---

## Resources

### Internal Documentation
- [Dokumentasi Backend Lengkap](./DOKUMENTASI_BACKEND.md)
- [Database Schema Detail](./DATABASE_SCHEMA.md)
- [Controllers & API Docs](./CONTROLLERS_API.md)
- [Development Guide](./DEVELOPMENT_GUIDE.md)

### External Resources
- [Laravel Official Docs](https://laravel.com/docs)
- [Laravel API Reference](https://laravel.com/api)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templates](https://laravel.com/docs/blade)
- [Testing](https://laravel.com/docs/testing)

### Tools
- [Postman Collection](./postman-collection.json) - If exists
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel Telescope](https://laravel.com/docs/telescope)

---

## Contact & Support

Untuk pertanyaan atau issue:
1. Check dokumentasi terlebih dahulu
2. Search existing issues di GitHub
3. Buat issue baru dengan detail lengkap
4. Untuk critical issues: Email development team

---

**Terakhir diupdate:** 5 Maret 2026  
**Versi:** 1.0.0  
**Maintained by:** Development Team - Citra Husada
