# Dokumentasi Backend - LMS Citra Husada

## Daftar Isi
1. [Pengenalan](#pengenalan)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Project](#struktur-project)
4. [Setup Development](#setup-development)
5. [Konfigurasi](#konfigurasi)
6. [Database](#database)
7. [Authentication](#authentication)
8. [API Endpoints](#api-endpoints)
9. [Error Handling](#error-handling)
10. [Troubleshooting](#troubleshooting)

---

## Pengenalan

LMS Citra Husada adalah Learning Management System (Sistem Manajemen Pembelajaran) yang dibangun untuk Rumah Sakit Citra Husada. Backend sistem ini dibangun menggunakan Laravel 11, framework PHP modern yang powerful dan scalable.

### Fitur Utama:
- **Autentikasi berbasis Session** - Login dengan NIK dan password
- **Manajemen Pengguna** - Super Admin, Admin, Teacher, Karyawan
- **Manajemen Materi Pembelajaran** - CRUD operations untuk materi, sub-materi
- **Sistem Jenis Tenaga Kerja** - Klasifikasi bedasarkan jenis profesi (Dokter, Perawat, etc)
- **Unit Kerja** - Organisasi berbasis departemen/unit
- **Post Test** - Evaluasi pembelajaran
- **Sertifikat** - Pencatatan sertifikasi peserta

---

## Teknologi yang Digunakan

### Backend Stack:
- **Laravel 11** - Framework PHP
- **PHP 8.2.26** - Bahasa pemrograman
- **MySQL 8.0.30** - Database relasional
- **Composer** - PHP Package Manager

### Frontend Stack:
- **Blade Templates** - Template engine Laravel
- **Tailwind CSS** - CSS Framework
- **Vite** - Build tool
- **Axios** - HTTP Client JavaScript

### Tools:
- **Laragon** - Local development environment
- **Git** - Version control
- **PHPUnit** - Testing framework

---

## Struktur Project

```
LMS-CitraHusada/
├── app/                          # Aplikasi utama
│   ├── Http/
│   │   └── Controllers/          # Route handlers
│   │       └── AuthController.php
│   │       └── JenisTenagaController.php
│   └── Models/                   # Eloquent Models
│       ├── User.php
│       ├── Role.php
│       ├── JenisTenaga.php
│       ├── UnitKerja.php
│       ├── Materi.php
│       ├── SubMateri.php
│       ├── PostTest.php
│       ├── Sertifikat.php
│       ├── MateriJenisTenaga.php
│       └── MateriUnitKerja.php
├── bootstrap/
│   ├── app.php                   # Bootstrap aplikasi (middleware config)
│   └── providers.php             # Service providers
├── config/                       # File konfigurasi
│   ├── app.php
│   ├── auth.php                  # Authentication config
│   ├── database.php              # Database config
│   ├── session.php               # Session config
│   └── ...
├── database/
│   ├── migrations/               # Database schema
│   ├── seeders/                  # Data seeder
│   └── factories/                # Model factories
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── login.blade.php
│   │   ├── pembelajaran.blade.php
│   │   └── components/
│   │       └── layout.blade.php
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js          # Axios configuration
│   └── css/
│       └── app.css
├── routes/
│   ├── api.php                   # API routes
│   ├── web.php                   # Web routes
│   └── console.php               # Console commands
├── storage/                      # File storage
├── tests/                        # Unit & Feature tests
├── public/                       # Public accessible files
│   ├── index.php                 # Entry point
│   ├── build/                    # Compiled assets
│   └── images/
├── .env                          # Environment variables
├── artisan                       # Laravel CLI
├── composer.json                 # Dependencies
└── package.json                  # NPM dependencies
```

---

## Setup Development

### Prasyarat:
- PHP 8.2 atau lebih tinggi
- MySQL 8.0 atau lebih tinggi
- Composer
- Node.js 20.15+ (untuk asset building)
- Laragon atau XAMPP

### Langkah Installation:

#### 1. Clone Repository
```bash
git clone https://github.com/AryaAP23/LMS-CitraHusada.git
cd LMS-CitraHusada
```

#### 2. Install PHP Dependencies
```bash
composer install
```

#### 3. Setup Environment File
```bash
cp .env.example .env
```

Edit `.env` file dengan konfigurasi database lokal Anda:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_citra_husada
DB_USERNAME=root
DB_PASSWORD=
```

#### 4. Generate Application Key
```bash
php artisan key:generate
```

#### 5. Create Database
```bash
# MySQL CLI method
mysql -u root -e "CREATE DATABASE lms_citra_husada CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Atau gunakan phpMyAdmin
```

#### 6. Run Migrations
```bash
php artisan migrate
```

#### 7. Run Seeders (Opsional)
```bash
php artisan db:seed
```

Atau seed tabel tertentu:
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UnitKerjaSeeder
php artisan db:seed --class=JenisTenagaSeeder
php artisan db:seed --class=UserSeeder
```

#### 8. Install Node Dependencies
```bash
npm install
```

#### 9. Build Assets
```bash
npm run build
```

Atau untuk development with watch:
```bash
npm run dev
```

#### 10. Start Development Server
```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000`

---

## Konfigurasi

### Environment Variables (.env)

```env
# APP
APP_NAME="LMS Citra Husada"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# DATABASE
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_citra_husada
DB_USERNAME=root
DB_PASSWORD=

# SESSION
SESSION_DRIVER=database
SESSION_LIFETIME=120

# CACHE
CACHE_DRIVER=file

# MAIL (Opsional)
MAIL_DRIVER=log
```

### Key Configuration Files:

#### `config/auth.php`
Konfigurasi authentication:
- Guard default: `web` (session-based)
- Provider: `users` (Eloquent model `App\Models\User`)
- Password reset broker

#### `config/database.php`
Konfigurasi koneksi database MySQL

#### `config/session.php`
Konfigurasi session:
- Driver: `database`
- Lifetime: 120 menit
- Table: `sessions`

---

## Database

### Schema Umum

#### Users Table
```sql
CREATE TABLE users (
    user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255),
    nik VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    jenis_tenaga_id BIGINT,
    unit_kerja_id BIGINT,
    role_id BIGINT,
    status BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (jenis_tenaga_id) REFERENCES jenis_tenagas(jenis_tenaga_id),
    FOREIGN KEY (unit_kerja_id) REFERENCES unit_kerjas(unit_kerja_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);
```

#### Roles Table
```sql
CREATE TABLE roles (
    role_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(255) UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

Default roles:
- Super Admin
- Admin
- Teacher
- Karyawan

#### Jenis Tenaga Table
```sql
CREATE TABLE jenis_tenagas (
    jenis_tenaga_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    jenis_tenaga VARCHAR(255) UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

Contoh jenis tenaga:
- Dokter
- Perawat
- Bidan
- Farmasis

#### Unit Kerja Table
```sql
CREATE TABLE unit_kerjas (
    unit_kerja_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    unit_kerja VARCHAR(255) UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Model Relationships

```
User
├── belongsTo(Role)
├── belongsTo(JenisTenaga)
└── belongsTo(UnitKerja)

Materi
├── belongsToMany(JenisTenaga) - MateriJenisTenaga
├── belongsToMany(UnitKerja) - MateriUnitKerja
└── hasMany(SubMateri)

SubMateri
├── belongsTo(Materi)
└── hasMany(PostTest)
```

---

## Authentication

### Login Flow

#### 1. User Submit Login Form
```javascript
// Frontend (login.blade.php)
axios.post('/api/login', {
    nik: '0112.01072',
    password: '123',
    remember: true
});
```

#### 2. Backend Process
```php
// AuthController@loginApi
Auth::attempt(['nik' => $nik, 'password' => $password]);
```

#### 3. Session Created
Session diset oleh Laravel, cookie `laravel-session` dikirim ke browser.

#### 4. Redirect ke Dashboard
```javascript
window.location.href = '/pembelajaran';
```

### Session Base Authentication

**Karakteristik:**
- Berbasis server-side session
- Session data disimpan di database (tabel `sessions`)
- Cookie `laravel-session` sebagai session identifier
- CSRF protection dengan token

### Middleware Authentication

Route yang memerlukan autentikasi:
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/pembelajaran', function () {
        return view('pembelajaran');
    });
});
```

### Default Test Account

```
NIK: 0112.01072
Password: 123
Name: dr. Susilo Wardhani S, MM
Role: Karyawan
Unit: TIK Unit
```

Semua 400 user di database menggunakan password yang sama: **123**

---

## API Endpoints

### Base URL
```
http://127.0.0.1:8000/api
```

### Authentication Endpoints

#### Login
```
POST /api/login
Content-Type: application/json

{
    "nik": "0112.01072",
    "password": "123",
    "remember": true
}

Response (200):
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": { ... },
        "redirect": "/pembelajaran"
    }
}
```

#### Check Auth Status
```
GET /api/check-auth
Cookie: laravel-session=...

Response (200):
{
    "success": true,
    "message": "User sudah ter-login",
    "data": {
        "user": { ... }
    }
}

Response (401):
{
    "success": false,
    "message": "User belum login"
}
```

#### Logout
```
POST /api/logout
Cookie: laravel-session=...

Response (200):
{
    "success": true,
    "message": "Logout berhasil"
}
```

### Jenis Tenaga Endpoints

#### List All
```
GET /api/jenis-tenaga

Response (200):
{
    "data": [
        {
            "jenis_tenaga_id": 1,
            "jenis_tenaga": "Dokter",
            "created_at": "2026-03-02T09:00:00Z",
            "updated_at": "2026-03-02T09:00:00Z"
        }
    ]
}
```

#### Get Detail
```
GET /api/jenis-tenaga/:id

Response (200):
{
    "data": { ... }
}
```

#### Create (Auth Required)
```
POST /api/jenis-tenaga
Cookie: laravel-session=...
Content-Type: application/json

{
    "jenis_tenaga": "Dokter Gigi"
}

Response (201):
{
    "data": { ... }
}
```

#### Update (Auth Required)
```
PUT /api/jenis-tenaga/:id
Cookie: laravel-session=...
Content-Type: application/json

{
    "jenis_tenaga": "Dokter Spesialis"
}

Response (200):
{
    "data": { ... }
}
```

#### Delete (Auth Required)
```
DELETE /api/jenis-tenaga/:id
Cookie: laravel-session=...

Response (204): No Content
```

---

## Error Handling

### HTTP Status Codes

| Code | Meaning | Contoh |
|------|---------|--------|
| 200 | OK | Request berhasil |
| 201 | Created | Resource berhasil dibuat |
| 400 | Bad Request | Validation error |
| 401 | Unauthorized | Session expired/belum login |
| 403 | Forbidden | Tidak punya akses |
| 404 | Not Found | Resource tidak ditemukan |
| 500 | Server Error | Error di backend |

### Error Response Format
```json
{
    "success": false,
    "message": "Error message",
    "data": {
        "field_name": ["Error detail 1", "Error detail 2"]
    }
}
```

### Common Errors

#### NIK atau Password Salah
```json
{
    "success": false,
    "message": "Password salah untuk user dengan NIK ini"
}
```

#### User Tidak Ditemukan
```json
{
    "success": false,
    "message": "User dengan NIK tersebut tidak ditemukan"
}
```

#### Validation Error
```json
{
    "success": false,
    "message": "Validasi gagal",
    "data": {
        "nik": ["NIK harus diisi", "NIK harus unique"],
        "password": ["Password minimal 3 karakter"]
    }
}
```

---

## Troubleshooting

### Database Connection Error
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solusi:**
1. Pastikan MySQL service berjalan
2. Cek `.env` DB_HOST, DB_USER, DB_PASSWORD
3. Pastikan database sudah dibuat
```bash
mysql -u root -e "SHOW DATABASES;" | grep lms_citra
```

### Session Not Persisting
```
User sudah ter-login tapi redirect ke login page
```

**Solusi:**
1. Pastikan session driver di `.env` diset ke `database`
2. Pastikan migrations sudah dijalankan: `php artisan migrate`
3. Cek tabel `sessions` ada di database
4. Clear session: `php artisan session:table` kemudian `php artisan migrate`

### Password Hash Mismatch
```
Login gagal padahal NIK dan password benar
```

**Solusi:**
Setel ulang password semua user dengan script:
```bash
php artisan tinker
> $hash = Hash::make('123');
> User::query()->update(['password' => $hash]);
```

### CSRF Token Error
```
CSRF token mismatch
```

**Solusi:**
1. Pastikan CSRF token di form:
```html
<form>
    @csrf
    ...
</form>
```

2. Axios sudah dikonfigurasi:
```javascript
// bootstrap.js
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
```

### Middleware 404 Error
```
Route not found / 404
```

**Solusi:**
1. Cek route definition di `routes/api.php` atau `routes/web.php`
2. Jalankan: `php artisan route:list`
3. Pastikan URL benar (case-sensitive)

### File Permission Error
```
Storage directory is not writable
```

**Solusi:**
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## Development Best Practices

### Code Style
- Menggunakan PSR-12 untuk PHP code style
- Variable names: camelCase untuk PHP, snake_case untuk database
- Class names: PascalCase

### Database
- Selalu gunakan migrations untuk schema changes
- Gunakan timestamps (`created_at`, `updated_at`)
- Foreign keys harus dikonfigurasi dengan cascade delete jika perlu

### API
- Gunakan HTTP methods dengan benar (GET, POST, PUT, DELETE)
- Return consistent JSON response format
- Validate input dengan Form Request atau manual validation

### Security
- Hash password dengan `Hash::make()`
- Validate semua input user
- Use CSRF protection
- Set `fillable` di Model untuk mass assignment
- Gunakan `hidden` untuk sensitive data (password)

---

## Resources Tambahan

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel API Documentation](https://laravel.com/api)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Testing](https://laravel.com/docs/testing)

---

**Terakhir diupdate:** 5 Maret 2026  
**Versi:** 1.0.0  
**Author:** Development Team - Citra Husada
