# Dokumentasi Database Schema - LMS Citra Husada

## Daftar Tabel

1. [Users](#users)
2. [Roles](#roles)
3. [Jenis Tenaga](#jenis-tenaga)
4. [Unit Kerja](#unit-kerja)
5. [Materi](#materi)
6. [Sub Materi](#sub-materi)
7. [Post Test](#post-test)
8. [Sertifikat](#sertifikat)
9. [Materi Jenis Tenaga (Pivot)](#materi-jenis-tenaga)
10. [Materi Unit Kerja (Pivot)](#materi-unit-kerja)
11. [Sessions](#sessions)

---

## Users

**Tabel:** `users`  
**Primary Key:** `user_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| user_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| nama | VARCHAR(255) | No | - | Nama lengkap pengguna |
| nik | VARCHAR(255) | No | - | Nomor Identitas Karyawan (unique) |
| password | VARCHAR(255) | No | - | Password terenkripsi (bcrypt) |
| jenis_tenaga_id | BIGINT | No | - | Foreign key ke jenis_tenagas |
| unit_kerja_id | BIGINT | No | - | Foreign key ke unit_kerjas |
| role_id | BIGINT | No | - | Foreign key ke roles |
| status | TINYINT | No | 1 | 1=aktif, 0=non-aktif |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (jenis_tenaga_id) REFERENCES jenis_tenagas(jenis_tenaga_id)
FOREIGN KEY (unit_kerja_id) REFERENCES unit_kerjas(unit_kerja_id)
FOREIGN KEY (role_id) REFERENCES roles(role_id)
```

### Eloquent Model
```php
namespace App\Models;

class User extends Authenticatable {
    protected $primaryKey = 'user_id';
    protected $fillable = ['nama', 'nik', 'password', 'jenis_tenaga_id', 'unit_kerja_id', 'role_id', 'status'];
    protected $hidden = ['password'];
    
    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    public function jenisTenaga() {
        return $this->belongsTo(JenisTenaga::class, 'jenis_tenaga_id');
    }
    
    public function unitKerja() {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }
}
```

### Sample Data
```sql
INSERT INTO users (user_id, nama, nik, password, jenis_tenaga_id, unit_kerja_id, role_id, status)
VALUES (1, 'dr. Susilo Wardhani S, MM', '0112.01072', '$2y$12$...hashed...', 1, 1, 4, 1);
```

---

## Roles

**Tabel:** `roles`  
**Primary Key:** `role_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| role_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| role | VARCHAR(255) | No | - | Nama role (unique) |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Default Roles
```sql
INSERT INTO roles (role) VALUES 
('Super Admin'),
('Admin'),
('Teacher'),
('Karyawan');
```

### Deskripsi
- **Super Admin** - Full access, manage seluruh sistem
- **Admin** - Manage user, konten, dan laporan
- **Teacher** - Membuat dan manage materi pembelajaran
- **Karyawan** - Peserta pembelajaran, hanya lihat materi

---

## Jenis Tenaga

**Tabel:** `jenis_tenagas`  
**Primary Key:** `jenis_tenaga_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| jenis_tenaga_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| jenis_tenaga | VARCHAR(255) | No | - | Jenis profesi (unique) |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Sample Data
```sql
INSERT INTO jenis_tenagas (jenis_tenaga) VALUES 
('Dokter'),
('Perawat'),
('Bidan'),
('Farmasis'),
('Gizi');
```

### Eloquent Model
```php
class JenisTenaga extends Model {
    protected $primaryKey = 'jenis_tenaga_id';
    protected $fillable = ['jenis_tenaga'];
    
    public function users() {
        return $this->hasMany(User::class, 'jenis_tenaga_id');
    }
    
    public function materis() {
        return $this->belongsToMany(Materi::class, 'materi_jenis_tenagas');
    }
}
```

---

## Unit Kerja

**Tabel:** `unit_kerjas`  
**Primary Key:** `unit_kerja_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| unit_kerja_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| unit_kerja | VARCHAR(255) | No | - | Nama unit/departemen (unique) |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Sample Data
```sql
INSERT INTO unit_kerjas (unit_kerja) VALUES 
('TIK Unit'),
('HR Unit'),
('Finance Unit'),
('Medical Unit'),
('Nursing Unit');
```

### Eloquent Model
```php
class UnitKerja extends Model {
    protected $primaryKey = 'unit_kerja_id';
    protected $fillable = ['unit_kerja'];
    
    public function users() {
        return $this->hasMany(User::class, 'unit_kerja_id');
    }
    
    public function materis() {
        return $this->belongsToMany(Materi::class, 'materi_unit_kerjas');
    }
}
```

---

## Materi

**Tabel:** `materis`  
**Primary Key:** `materi_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| materi_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| judul | VARCHAR(255) | No | - | Judul materi pembelajaran |
| deskripsi | TEXT | Yes | NULL | Deskripsi lengkap materi |
| konten | LONGTEXT | Yes | NULL | Isi materi (HTML) |
| durasi_jpl | INT | Yes | NULL | Durasi dalam Jam Pelajaran (JPL) |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Eloquent Model
```php
class Materi extends Model {
    protected $primaryKey = 'materi_id';
    protected $fillable = ['judul', 'deskripsi', 'konten', 'durasi_jpl'];
    
    public function subMateris() {
        return $this->hasMany(SubMateri::class, 'materi_id');
    }
    
    public function jenisTenagas() {
        return $this->belongsToMany(JenisTenaga::class, 'materi_jenis_tenagas');
    }
    
    public function unitKerjas() {
        return $this->belongsToMany(UnitKerja::class, 'materi_unit_kerjas');
    }
}
```

---

## Sub Materi

**Tabel:** `sub_materis`  
**Primary Key:** `sub_materi_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| sub_materi_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| materi_id | BIGINT | No | - | Foreign key ke materis |
| judul | VARCHAR(255) | No | - | Judul sub-materi |
| urutan | INT | Yes | NULL | Urutan tampilan |
| konten | LONGTEXT | Yes | NULL | Isi sub-materi (HTML) |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (materi_id) REFERENCES materis(materi_id) ON DELETE CASCADE
```

### Eloquent Model
```php
class SubMateri extends Model {
    protected $primaryKey = 'sub_materi_id';
    protected $fillable = ['materi_id', 'judul', 'urutan', 'konten'];
    
    public function materi() {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
    
    public function postTests() {
        return $this->hasMany(PostTest::class, 'sub_materi_id');
    }
}
```

---

## Post Test

**Tabel:** `post_tests`  
**Primary Key:** `post_test_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| post_test_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| sub_materi_id | BIGINT | No | - | Foreign key ke sub_materis |
| soal | LONGTEXT | No | - | Pertanyaan test |
| tipe_soal | VARCHAR(50) | No | - | pilihan_ganda / essay / matching |
| jawaban_benar | TEXT | No | - | Jawaban yang benar |
| poin | INT | Yes | 1 | Poin untuk soal ini |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (sub_materi_id) REFERENCES sub_materis(sub_materi_id) ON DELETE CASCADE
```

### Tipe Soal
- `pilihan_ganda` - Multiple choice
- `essay` - Essay/text answer
- `matching` - Matching questions

### Eloquent Model
```php
class PostTest extends Model {
    protected $primaryKey = 'post_test_id';
    protected $fillable = ['sub_materi_id', 'soal', 'tipe_soal', 'jawaban_benar', 'poin'];
    
    public function subMateri() {
        return $this->belongsTo(SubMateri::class, 'sub_materi_id');
    }
}
```

---

## Sertifikat

**Tabel:** `sertifikats`  
**Primary Key:** `sertifikat_id` (BIGINT)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| sertifikat_id | BIGINT | No | AUTO_INCREMENT | Primary key |
| user_id | BIGINT | No | - | Foreign key ke users |
| nomor_sertifikat | VARCHAR(255) | No | - | Nomor sertifikat (unique) |
| judul_sertifikat | VARCHAR(255) | No | - | Nama sertifikat |
| tanggal_terbit | DATE | No | - | Tanggal sertifikat diterbitkan |
| nilai_akhir | DECIMAL(5,2) | Yes | NULL | Nilai akhir pembelajaran |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
```

### Eloquent Model
```php
class Sertifikat extends Model {
    protected $primaryKey = 'sertifikat_id';
    protected $fillable = ['user_id', 'nomor_sertifikat', 'judul_sertifikat', 'tanggal_terbit', 'nilai_akhir'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

---

## Materi Jenis Tenaga (Pivot)

**Tabel:** `materi_jenis_tenagas`  
**Primary Key:** Composite (materi_id, jenis_tenaga_id)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| materi_id | BIGINT | No | - | Foreign key ke materis |
| jenis_tenaga_id | BIGINT | No | - | Foreign key ke jenis_tenagas |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (materi_id) REFERENCES materis(materi_id) ON DELETE CASCADE
FOREIGN KEY (jenis_tenaga_id) REFERENCES jenis_tenagas(jenis_tenaga_id) ON DELETE CASCADE
```

### Tujuan
Menyimpan relasi many-to-many antara Materi dan Jenis Tenaga. Setiap materi bisa ditargetkan ke multiple jenis tenaga.

### Query Example
```php
// Ambil semua materi untuk Dokter
$materiDokter = Materi::whereHas('jenisTenagas', function($q) {
    $q->where('jenis_tenaga_id', 1);
})->get();

// Attach jenis tenaga ke materi
$materi->jenisTenagas()->attach($jenisTenagaId);

// Detach
$materi->jenisTenagas()->detach($jenisTenagaId);
```

---

## Materi Unit Kerja (Pivot)

**Tabel:** `materi_unit_kerjas`  
**Primary Key:** Composite (materi_id, unit_kerja_id)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| materi_id | BIGINT | No | - | Foreign key ke materis |
| unit_kerja_id | BIGINT | No | - | Foreign key ke unit_kerjas |
| created_at | TIMESTAMP | Yes | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | Yes | NULL | Waktu terakhir diubah |

### Foreign Keys
```sql
FOREIGN KEY (materi_id) REFERENCES materis(materi_id) ON DELETE CASCADE
FOREIGN KEY (unit_kerja_id) REFERENCES unit_kerjas(unit_kerja_id) ON DELETE CASCADE
```

### Query Example
```php
// Ambil materi untuk unit TIK
$materiTIK = Materi::whereHas('unitKerjas', function($q) {
    $q->where('unit_kerja_id', 1);
})->get();
```

---

## Sessions

**Tabel:** `sessions`  
**Primary Key:** String (51 chars)

### Kolom

| Kolom | Type | Nullable | Default | Keterangan |
|-------|------|----------|---------|-----------|
| id | VARCHAR(255) | No | - | Session ID (Primary key) |
| user_id | BIGINT | Yes | NULL | User ID if authenticated |
| ip_address | VARCHAR(45) | Yes | NULL | IP address client |
| user_agent | TEXT | Yes | NULL | Browser user agent |
| payload | LONGTEXT | No | - | Serialized session data |
| last_activity | INT | No | - | Unix timestamp last activity |

### Tujuan
Menyimpan session data user. Dibuat otomatis oleh Laravel saat user login.

### Migration Command
```bash
php artisan session:table
php artisan migrate
```

---

## Database Diagram

```
┌─────────────┐
│   Users     │
├─────────────┤
│ user_id (PK)│────┐
│ nik (unique)│    │
│ password    │    │
│ role_id (FK)├────┼──── Roles
│ jenis...    ├────┼──── JenisTenaga
│ unit...     ├────┼──── UnitKerja
└─────────────┘    │
                   │
┌─────────────────┐ │
│ Materis         │ │
├─────────────────┤ │
│ materi_id (PK)  │<┤
│ judul           │
│ konten          │
└─────────────────┘
      │
      ├── SubMateris ──── PostTest
      │
      ├── MaterialJenisTenaga (pivot) ──┐
      │                                  ├── JenisTenaga
      └── MateriUnitKerja (pivot) ──────┐
                                         ├── UnitKerja

┌──────────────────┐
│ Sertifikat       │
├──────────────────┤
│ sertifikat_id(PK)│
│ user_id (FK)  ───┼─── Users
│ nilai_akhir      │
└──────────────────┘
```

---

## Tips & Best Practices

### Indexing
Pastikan index dibuat untuk foreign keys:
```sql
CREATE INDEX idx_user_role ON users(role_id);
CREATE INDEX idx_user_jenis ON users(jenis_tenaga_id);
CREATE INDEX idx_user_unit ON users(unit_kerja_id);
CREATE INDEX idx_submateri_materi ON sub_materis(materi_id);
CREATE INDEX idx_posttest_submateri ON post_tests(sub_materi_id);
```

### Query Optimization
Gunakan eager loading untuk menghindari N+1 problem:
```php
// Good
$users = User::with('role', 'jenisTenaga', 'unitKerja')->get();

// Bad (N+1 problem)
$users = User::all();
foreach ($users as $user) {
    echo $user->role->role; // Query setiap loop
}
```

### Data Integrity
- Selalu gunakan ON DELETE CASCADE pada foreign key jika perlu
- Validate data di application level sebelum insert
- Gunakan transactions untuk multi-table operations

---

**Terakhir diupdate:** 5 Maret 2026  
**Versi:** 1.0.0
