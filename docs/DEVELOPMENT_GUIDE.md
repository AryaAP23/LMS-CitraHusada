# Panduan Development & Kontribusi - LMS Citra Husada

## Daftar Isi

1. [Development Environment Setup](#development-environment-setup)
2. [Project Structure Guide](#project-structure-guide)
3. [Coding Standards](#coding-standards)
4. [Creating Models](#creating-models)
5. [Creating Controllers](#creating-controllers)
6. [Creating Migrations](#creating-migrations)
7. [Creating Routes](#creating-routes)
8. [Testing](#testing)
9. [Git Workflow](#git-workflow)
10. [Troubleshooting](#troubleshooting)

---

## Development Environment Setup

### Requirement Checks

```bash
# Cek PHP version
php -v
# Minimal: PHP 8.2

# Cek MySQL version
mysql --version
# Minimal: MySQL 8.0

# Cek Composer
composer --version

# Cek Node.js
node --version
npm --version
# Node: 20.15+
```

### Fresh Development Setup

```bash
# 1. Clone project
git clone https://github.com/AryaAP23/LMS-CitraHusada.git
cd LMS-CitraHusada

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env

# Edit .env dengan database credentials
# DB_DATABASE=lms_citra_husada
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Generate app key
php artisan key:generate

# 5. Create database
mysql -u root -e "CREATE DATABASE lms_citra_husada CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Run migrations
php artisan migrate

# 7. (Optional) Seed database
php artisan db:seed

# 8. Build assets
npm run build

# 9. Start development server
php artisan serve
# Access: http://127.0.0.1:8000
```

### Watch Mode Development

**Terminal 1 - PHP Server:**
```bash
php artisan serve
```

**Terminal 2 - Asset Watcher:**
```bash
npm run dev
```

Browser akan auto-reload ketika ada perubahan di `resources/` folder.

---

## Project Structure Guide

### App Directory Structure

```
app/
├── Http/
│   ├── Controllers/          # Route handlers
│   │   ├── AuthController.php
│   │   ├── JenisTenagaController.php
│   │   └── [YourController.php]
│   └── Middleware/           # Custom middleware (jika ada)
│
├── Models/                   # Eloquent Models
│   ├── User.php
│   ├── Role.php
│   ├── JenisTenaga.php
│   └── [YourModel.php]
│
└── Providers/                # Service providers
    └── AppServiceProvider.php
```

### Database Directory

```
database/
├── migrations/               # Schema definitions
│   └── *.php
├── seeders/                  # Data seeders
│   ├── DatabaseSeeder.php
│   ├── RoleSeeder.php
│   └── [YourSeeder.php]
└── factories/                # Model factories for testing
    └── UserFactory.php
```

### Resources Directory

```
resources/
├── views/                    # Blade templates
│   ├── login.blade.php
│   ├── pembelajaran.blade.php
│   └── components/
│       └── layout.blade.php
├── js/                       # JavaScript modules
│   ├── app.js
│   ├── bootstrap.js          # Axios & global config
│   └── [your-script.js]
└── css/                      # CSS/Tailwind
    └── app.css
```

### Routes Directory

```
routes/
├── api.php                   # JSON API routes
│   Example: /api/login, /api/jenis-tenaga
│
├── web.php                   # HTML form routes
│   Example: /, /pembelajaran
│
└── console.php               # Artisan commands
```

---

## Coding Standards

### PHP Code Style (PSR-12)

#### Naming Conventions

```php
// Classes: PascalCase
class UserController { }

// Methods: camelCase
public function getUserProfile() { }

// Properties: camelCase
private $userName;

// Constants: UPPER_SNAKE_CASE
const MAX_LOGIN_ATTEMPTS = 5;

// Variables: $snake_case (database), camelCase (PHP)
$nik = '0112.01072'; // database column
$userName = 'John';  // local variable
```

#### File Structure

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
    /**
     * Show login page.
     */
    public function showLogin() {
        return view('login');
    }
    
    /**
     * Process login.
     */
    public function login(Request $request) {
        // ...
    }
}
```

#### Formatting

```php
// Method signatures
public function store(Request $request, User $user) {
    //
}

// Array formatting
$data = [
    'name'  => 'John',
    'email' => 'john@example.com',
];

// If statements
if ($user->isAdmin()) {
    // do something
} else {
    // do something else
}

// Long lines
$users = User::where('status', true)
    ->where('unit_kerja_id', $unitId)
    ->orderBy('nama')
    ->get();
```

#### Documentation Comments

```php
/**
 * Store a new user in database.
 * 
 * @param \Illuminate\Http\Request $request
 * @param \App\Models\User $user
 * @return \Illuminate\Http\Response
 */
public function store(Request $request, User $user) {
    //
}
```

### Blade Template Style

```blade
{{-- Use comments for Blade --}}

{{-- Display variables --}}
<h1>{{ $title }}</h1>

{{-- Conditionals --}}
@if ($user->isAdmin())
    <p>Admin Panel</p>
@endif

{{-- Loops --}}
@foreach ($users as $user)
    <p>{{ $user->nama }}</p>
@endforeach

{{-- Include components --}}
@include('components.user-card', ['user' => $user])

{{-- CSRF token in forms --}}
<form>
    @csrf
    <input type="submit" value="Submit">
</form>
```

---

## Creating Models

### Generate Model with Migration

```bash
php artisan make:model Materi -m
# Creates:
# - app/Models/Materi.php
# - database/migrations/YYYY_MM_DD_HHMMSS_create_materis_table.php
```

### Model Template

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model {
    protected $primaryKey = 'materi_id';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'durasi_jpl',
    ];
    
    /**
     * Get all sub-materi for this materi.
     */
    public function subMateris() {
        return $this->hasMany(SubMateri::class, 'materi_id');
    }
    
    /**
     * Get all jenis tenaga for this materi.
     */
    public function jenisTenagas() {
        return $this->belongsToMany(
            JenisTenaga::class,
            'materi_jenis_tenagas'
        );
    }
}
```

### Relationships Guide

```php
// One-to-Many
class User extends Model {
    public function sertifikats() {
        return $this->hasMany(Sertifikat::class, 'user_id');
    }
}

// Many-to-One
class Sertifikat extends Model {
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

// Many-to-Many
class Materi extends Model {
    public function jenisTenagas() {
        return $this->belongsToMany(
            JenisTenaga::class,
            'materi_jenis_tenagas',
            'materi_id',
            'jenis_tenaga_id'
        );
    }
}
```

---

## Creating Controllers

### Generate Controller

```bash
php artisan make:controller MateriController --model=Materi
# Creates: app/Http/Controllers/MateriController.php
# With stub methods for CRUD
```

### API Controller Template

```php
<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $materis = Materi::all();
        return response()->json(['data' => $materis]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Materi $materi) {
        return response()->json(['data' => $materi]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'judul'      => 'required|string',
            'deskripsi'  => 'nullable|string',
            'konten'     => 'nullable|string',
            'durasi_jpl' => 'nullable|integer',
        ]);
        
        $materi = Materi::create($validated);
        
        return response()->json(['data' => $materi], 201);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi) {
        $validated = $request->validate([
            'judul'      => 'required|string',
            'deskripsi'  => 'nullable|string',
            'konten'     => 'nullable|string',
            'durasi_jpl' => 'nullable|integer',
        ]);
        
        $materi->update($validated);
        
        return response()->json(['data' => $materi]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi) {
        $materi->delete();
        return response()->noContent();
    }
}
```

---

## Creating Migrations

### Generate Migration

```bash
# Empty migration
php artisan make:migration create_materis_table

# With model/controller
php artisan make:model Materi -m
```

### Migration Template

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterisTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('materis', function (Blueprint $table) {
            $table->id('materi_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->longText('konten')->nullable();
            $table->integer('durasi_jpl')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('materis');
    }
}
```

### Common Column Types

```php
$table->id();                    // BIGINT AUTO_INCREMENT
$table->string('name');          // VARCHAR(255)
$table->text('description');     // TEXT
$table->longText('content');     // LONGTEXT
$table->integer('count');        // INT
$table->decimal('price', 8, 2);  // DECIMAL(8,2)
$table->boolean('is_active');    // TINYINT(1)
$table->date('birth_date');      // DATE
$table->timestamp('created_at'); // TIMESTAMP
$table->timestamps();            // created_at, updated_at
$table->softDeletes();           // deleted_at
$table->unique('email');         // UNIQUE constraint
$table->nullable();              // NULL allowed

// Foreign keys
$table->foreignId('user_id')     // BIGINT
    ->references('id')
    ->on('users')
    ->onDelete('cascade');
```

### Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Rollback last batch
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset

# Refresh (reset + run)
php artisan migrate:refresh

# Refresh with seeding
php artisan migrate:refresh --seed
```

---

## Creating Routes

### API Routes

**File:** `routes/api.php`

```php
// Public routes
Route::get('/jenis-tenaga', [JenisTenagaController::class, 'index']);
Route::get('/jenis-tenaga/{jenisTenaga}', [JenisTenagaController::class, 'show']);

Route::post('/login', [AuthController::class, 'loginApi']);
Route::get('/check-auth', function (Request $request) {
    if (auth()->check()) {
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 401);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutApi']);
    
    Route::post('/jenis-tenaga', [JenisTenagaController::class, 'store']);
    Route::put('/jenis-tenaga/{jenisTenaga}', [JenisTenagaController::class, 'update']);
    Route::delete('/jenis-tenaga/{jenisTenaga}', [JenisTenagaController::class, 'destroy']);
});
```

### Web Routes

**File:** `routes/web.php`

```php
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/pembelajaran', function () {
        return view('pembelajaran');
    })->name('pembelajaran');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
```

### List Routes

```bash
# See all routes
php artisan route:list

# Filter by URI
php artisan route:list --path=api

# Show with full details
php artisan route:list -v
```

---

## Testing

### Laravel Testing Setup

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# With coverage report
php artisan test --coverage
```

### Creating Tests

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase {
    /**
     * Test login API.
     */
    public function test_login_with_valid_credentials() {
        $user = User::first();
        
        $response = $this->postJson('/api/login', [
            'nik'      => $user->nik,
            'password' => '123',
        ]);
        
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }
    
    /**
     * Test login with invalid credentials.
     */
    public function test_login_with_invalid_credentials() {
        $response = $this->postJson('/api/login', [
            'nik'      => 'invalid',
            'password' => 'wrong',
        ]);
        
        $response->assertStatus(401)
                 ->assertJson(['success' => false]);
    }
}
```

---

## Git Workflow

### Basic Git Commands

```bash
# Clone repository
git clone https://github.com/AryaAP23/LMS-CitraHusada.git

# Check status
git status

# Create new branch for feature
git checkout -b feature/new-feature-name

# Stage changes
git add .

# Commit with message
git commit -m "feat: add new feature description"

# Push to remote
git push origin feature/new-feature-name

# Create Pull Request on GitHub
```

### Commit Message Convention

Follow Conventional Commits format:

```
type(scope): subject line

feat:    A new feature
fix:     A bug fix
docs:    Documentation only changes
style:   Changes that don't affect code logic (formatting, etc)
refactor: Code change that neither fixes a bug nor adds a feature
perf:    Code change that improves performance
test:    Adding missing tests or correcting tests
chore:   Changes to build process, dependencies, etc

Examples:
- feat(auth): add Remember me functionality
- fix(login): fix session not persisting issue
- docs: update backend documentation
- refactor(controller): simplify validation logic
```

### Branch Naming Convention

```
feature/<feature-name>    # New features
bugfix/<bug-name>         # Bug fixes
docs/<doc-name>           # Documentation
refactor/<section-name>   # Code refactoring
hotfix/<issue-name>       # Emergency hotfixes
```

---

## Troubleshooting

### Common Development Issues

#### 1. After pulling new changes, migrations fail

```bash
# Solution: Run fresh migrations
php artisan migrate:refresh --seed
```

#### 2. Assets not updating in browser

```bash
# Solution: Clear cache and rebuild
php artisan config:cache
php artisan view:clear
npm run build

# Or with dev mode
npm run dev
```

#### 3. Composer dependency conflict

```bash
# Solution: Update composer
composer update

# Or reinstall
rm composer.lock
composer install
```

#### 4. Database errors after git pull

```bash
# Solution: Run migrations
php artisan migrate --step

# Check migrations status
php artisan migrate:status
```

#### 5. Session not working

```bash
# Solution: Recreate session table
php artisan session:table
php artisan migrate

# Or clear all sessions
php artisan session:clear
```

---

## Code Review Checklist

Sebelum membuat Pull Request, pastikan:

- [ ] Code mengikuti PSR-12 standards
- [ ] Semua tests pass: `php artisan test`
- [ ] Database migrations valid
- [ ] No console errors/warnings
- [ ] Changed files documented
- [ ] Commit messages clear dan descriptive
- [ ] No hardcoded values
- [ ] Input properly validated
- [ ] Error handling implemented
- [ ] Security considerations addressed

---

**Terakhir diupdate:** 5 Maret 2026  
**Versi:** 1.0.0
