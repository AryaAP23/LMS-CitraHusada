<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Proyek

LMS-CitraHusada adalah aplikasi Learning Management System berbasis Laravel
yang dikustomisasi untuk kebutuhan internal institusi kesehatan. Fitur utama
meliputi manajemen materi pembelajaran, sub-materi, post-test, sertifikat,
serta pengelolaan pengguna, unit kerja, dan jenis tenaga.

Proyek ini merupakan turunan dari kerangka kerja Laravel; panduan instalasi dan
fitur umum masih merujuk dokumentasi Laravel resmi, tetapi README ini menyajikan
petunjuk cepat konfigurasi dan penggunaan khusus repo ini.

---

## Persiapan Lingkungan

1. Clone repositori:
   ```bash
   git clone https://github.com/AryaAP23/LMS-CitraHusada.git
   cd LMS-CitraHusada
   ```
2. Install dependensi PHP dan JavaScript:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Salin file konfigurasi .env dan atur koneksi database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Jalankan migrasi dan seeder (refresh jika perlu):
   ```bash
   php artisan migrate --seed
   # atau untuk reset lengkap:
   php artisan migrate:refresh --seed
   ```

   Setelah seeder dijalankan, akun default tersedia untuk pengujian:
   - **NIK**: `admin`
   - **Password**: `password`

5. Jika ingin mengisi ulang tabel `unit_kerjas` saja setelah seeder diperbaiki:
   ```bash
   php artisan db:seed --class=UnitKerjaSeeder
   ```

---

## Struktur Database

Tabel utama mencakup:

- users (relasi ke roles, unit_kerjas, jenis_tenagas)
- roles, unit_kerjas, jenis_tenagas
- materis, sub_materis, post_tests
- materi_jenis_tenagas, materi_unit_kerjas (pivot)
- sertifikats, _login__texts

Dokumentasi migrasi tersedia di `database/migrations` untuk membantu pemahaman.

---

## Kontribusi

Silakan buat PR ke cabang `main` dan ikuti standar coding Laravel. Pastikan
menambahkan dokumentasi bila migrasi atau model baru dibuat.

---

## Lisensi

MIT License (sama seperti Laravel).  

---

> Catatan: Bagian awal README default Laravel tetap ada untuk referensi umum, tetapi
> informasi proyek lebih spesifik sudah ditambahkan di atas.

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
