# Dokumentasi Backend - LMS Citra Husada
## Index & Navigation

Selamat datang! Dokumentasi ini mencakup semua aspek backend LMS Citra Husada, termasuk setup, architecture, API references, dan development guides.

---

## 📚 Daftar Dokumentasi

### 1. **[DOKUMENTASI_BACKEND.md](./DOKUMENTASI_BACKEND.md)** - Dokumentasi Utama
👉 **Mulai dari sini untuk overview lengkap**

Mencakup:
- Pengenalan sistem
- Teknologi yang digunakan
- Struktur project
- Setup development environment
- Konfigurasi aplikasi
- Database overview
- Authentication system
- Basic API endpoints
- Error handling
- Troubleshooting umum

**Cocok untuk:** Pemula, onboarding baru, overview cepat

---

### 2. **[DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md)** - Dokumentasi Database
👉 **Untuk detail skema database dan relationships**

Mencakup:
- Detail setiap tabel
- Kolom, tipe data, constraints
- Eloquent model definitions
- Relationships (One-to-Many, Many-to-Many)
- Sample data
- Database diagram
- Query examples
- Best practices

**Cocok untuk:** Database designer, backend developer

---

### 3. **[CONTROLLERS_API.md](./CONTROLLERS_API.md)** - API Endpoints & Controllers
👉 **Untuk referensi endpoint API dan controller methods**

Mencakup:
- AuthController detail
- JenisTenagaController detail
- Request/Response format
- HTTP status codes
- Error handling
- Authentication flow
- Testing endpoints (cURL, Postman)

**Cocok untuk:** API developer, frontend developer, testing

---

### 4. **[DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md)** - Panduan Development
👉 **Untuk developer yang ingin berkontribusi atau extend**

Mencakup:
- Environment setup detail
- Project structure guide
- Coding standards (PSR-12)
- Creating models
- Creating controllers
- Creating migrations
- Creating routes
- Testing guide
- Git workflow
- Commit conventions
- Code review checklist

**Cocok untuk:** Developer, contributor, maintainer

---

### 5. **[QUICK_REFERENCE.md](./QUICK_REFERENCE.md)** - Quick Reference & FAQ
👉 **Untuk quick lookup dan jawaban pertanyaan umum**

Mencakup:
- Artisan commands cheatsheet
- NPM commands
- HTTP methods quick reference
- FAQ dengan solusi
- Performance tips
- Security best practices
- Troubleshooting tips

**Cocok untuk:** Semua level, quick lookup

---

## 🚀 Quick Start

### Untuk Developer Baru:
1. Baca: [DOKUMENTASI_BACKEND.md](./DOKUMENTASI_BACKEND.md) - Setup Development section
2. Jalankan setup commands
3. Baca: [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Understand struktur database
4. Baca: [CONTROLLERS_API.md](./CONTROLLERS_API.md) - Understand API flow

### Untuk Frontend Developer:
1. Baca: [DOKUMENTASI_BACKEND.md](./DOKUMENTASI_BACKEND.md) - Authentication section
2. Baca: [CONTROLLERS_API.md](./CONTROLLERS_API.md) - API Endpoints section
3. Gunakan [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) untuk testing API

### Untuk Backend Developer:
1. Setup mengikuti [DOKUMENTASI_BACKEND.md](./DOKUMENTASI_BACKEND.md)
2. Baca: [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Full database structure
3. Baca: [DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md) - Coding standards & practices
4. Refer [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) saat butuh quick lookup

### Untuk Testing API:
1. Setup testing tools (Postman, REST Client, atau cURL)
2. Baca: [CONTROLLERS_API.md](./CONTROLLERS_API.md) - Testing section
3. Gunakan [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) untuk command cheatsheet

---

## 📋 Struktur Dokumentasi

```
docs/
├── README.md                      ← File ini, navigation guide
├── DOKUMENTASI_BACKEND.md         ← Main documentation
├── DATABASE_SCHEMA.md             ← Database reference
├── CONTROLLERS_API.md             ← API endpoints reference
├── DEVELOPMENT_GUIDE.md           ← Development guide
└── QUICK_REFERENCE.md             ← Quick reference & FAQ
```

---

## 🔍 Quick Lookup by Topic

### **Authentication & Session**
- Overview: [DOKUMENTASI_BACKEND.md#authentication](./DOKUMENTASI_BACKEND.md#authentication)
- API calls: [CONTROLLERS_API.md#authcontroller](./CONTROLLERS_API.md#authcontroller)
- Troubleshooting: [QUICK_REFERENCE.md#authentication--session](./QUICK_REFERENCE.md#authentication--session)

### **Database**
- Setup: [DOKUMENTASI_BACKEND.md#database](./DOKUMENTASI_BACKEND.md#database)
- Schema detail: [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md)
- Relationships: [DATABASE_SCHEMA.md#model-relationships](./DATABASE_SCHEMA.md#model-relationships)
- Best practices: [DATABASE_SCHEMA.md#tips--best-practices](./DATABASE_SCHEMA.md#tips--best-practices)

### **API Endpoints**
- List: [DOKUMENTASI_BACKEND.md#api-endpoints](./DOKUMENTASI_BACKEND.md#api-endpoints)
- Detailed: [CONTROLLERS_API.md](./CONTROLLERS_API.md)
- Testing: [CONTROLLERS_API.md#testing-endpoints](./CONTROLLERS_API.md#testing-endpoints)

### **Development**
- Setup: [DEVELOPMENT_GUIDE.md#development-environment-setup](./DEVELOPMENT_GUIDE.md#development-environment-setup)
- Models: [DEVELOPMENT_GUIDE.md#creating-models](./DEVELOPMENT_GUIDE.md#creating-models)
- Controllers: [DEVELOPMENT_GUIDE.md#creating-controllers](./DEVELOPMENT_GUIDE.md#creating-controllers)
- Migrations: [DEVELOPMENT_GUIDE.md#creating-migrations](./DEVELOPMENT_GUIDE.md#creating-migrations)
- Testing: [DEVELOPMENT_GUIDE.md#testing](./DEVELOPMENT_GUIDE.md#testing)

### **Common Issues**
- Error handling: [DOKUMENTASI_BACKEND.md#error-handling](./DOKUMENTASI_BACKEND.md#error-handling)
- Troubleshooting: [DOKUMENTASI_BACKEND.md#troubleshooting](./DOKUMENTASI_BACKEND.md#troubleshooting)
- FAQ: [QUICK_REFERENCE.md#frequently-asked-questions-faq](./QUICK_REFERENCE.md#frequently-asked-questions-faq)

### **Code Standards**
- Conventions: [DEVELOPMENT_GUIDE.md#coding-standards](./DEVELOPMENT_GUIDE.md#coding-standards)
- Best practices: [DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md)

---

## 🎯 Common Tasks

### Setup Project
```bash
# See: DOKUMENTASI_BACKEND.md#setup-development
git clone https://github.com/AryaAP23/LMS-CitraHusada.git
composer install
npm install
# ... more steps in docs
```

### Testing API
```bash
# See: CONTROLLERS_API.md#testing-endpoints
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"nik":"0112.01072","password":"123"}'
```

### Create New Model
```bash
# See: DEVELOPMENT_GUIDE.md#creating-models
php artisan make:model Materi -m
```

### List Routes
```bash
# See: QUICK_REFERENCE.md#artisan-commands-sering-digunakan
php artisan route:list
```

### Debug Issue
1. Check [DOKUMENTASI_BACKEND.md#troubleshooting](./DOKUMENTASI_BACKEND.md#troubleshooting)
2. Look in [QUICK_REFERENCE.md#frequently-asked-questions-faq](./QUICK_REFERENCE.md#frequently-asked-questions-faq)
3. If still stuck, check related documentation

---

## 📞 Getting Help

### Ordered by Priority:

1. **Search Documentation** - Cari di dokumentasi terlebih dahulu
   - Use Ctrl+F untuk search dalam file
   - Check index section di atas

2. **Check FAQ** - [QUICK_REFERENCE.md](./QUICK_REFERENCE.md)
   - Jawaban untuk pertanyaan umum

3. **Review Examples** - Code examples di dokumentasi
   - Banyak contoh practical code

4. **GitHub Issues** - Cek issue yang sudah ada
   - Link: https://github.com/AryaAP23/LMS-CitraHusada/issues

5. **Create New Issue** - Jika tidak ketemu solusi
   - Include: error message, steps to reproduce, environment

---

## 📝 Documentation Metadata

| Item | Detail |
|------|--------|
| **Project** | LMS Citra Husada |
| **Framework** | Laravel 11 |
| **PHP Version** | 8.2.26 |
| **MySQL Version** | 8.0.30 |
| **Last Updated** | 5 Maret 2026 |
| **Documentation Version** | 1.0.0 |
| **Maintained By** | Development Team |
| **Repository** | https://github.com/AryaAP23/LMS-CitraHusada |

---

## 🔄 Documentation Updates

Dokumentasi ini diupdate secara berkala mengikuti perkembangan project.

### Changelog:
- **v1.0.0** (5 Maret 2026) - Initial documentation created
  - Dokumentasi Backend Lengkap
  - Database Schema Reference
  - Controllers & API Endpoints
  - Development Guide
  - Quick Reference & FAQ

---

## 💡 Tips Menggunakan Dokumentasi

1. **Gunakan Table of Contents** - Setiap file memiliki daftar isi
2. **Ctrl+F untuk Search** - Cepat menemukan topik
3. **Follow Links** - Dokumentasi saling terhubung
4. **Check Examples** - Banyak contoh kode praktis
5. **Refer to FAQ** - Jawaban quick untuk pertanyaan umum

---

## 📖 Recommended Reading Order

### Untuk Complete Understanding:
1. [DOKUMENTASI_BACKEND.md](./DOKUMENTASI_BACKEND.md) - Overview & setup
2. [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Understand data structure
3. [CONTROLLERS_API.md](./CONTROLLERS_API.md) - Understand API
4. [DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md) - Learn development
5. [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) - Bookmark for later

### Untuk Quick Start:
1. [DOKUMENTASI_BACKEND.md - Setup Development](./DOKUMENTASI_BACKEND.md#setup-development)
2. [QUICK_REFERENCE.md - Quick Reference](./QUICK_REFERENCE.md)

### Untuk Extending Project:
1. [DEVELOPMENT_GUIDE.md](./DEVELOPMENT_GUIDE.md) - Full guide
2. [DATABASE_SCHEMA.md](./DATABASE_SCHEMA.md) - Understand schema
3. [CONTROLLERS_API.md](./CONTROLLERS_API.md) - Understand patterns

---

## 🚀 Getting Started Now

```bash
# 1. Clone repository
git clone https://github.com/AryaAP23/LMS-CitraHusada.git
cd LMS-CitraHusada

# 2. Follow setup in DOKUMENTASI_BACKEND.md
# 3. Read DATABASE_SCHEMA.md to understand data
# 4. Test API using CONTROLLERS_API.md examples
# 5. Start development using DEVELOPMENT_GUIDE.md
```

---

**Happy Coding! 🎉**

Jika ada pertanyaan atau saran untuk dokumentasi, silahkan buat issue atau pull request.

---

*Documentation Version: 1.0.0*  
*Last Updated: 5 Maret 2026*  
*Maintained by: Development Team - Citra Husada*
