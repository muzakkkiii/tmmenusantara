# Menjalankan di Laragon (Windows) - Langkah dari Awal

Sudah diverifikasi: tidak ada error route, blade, maupun backend.
Ikuti urutan ini persis. Estimasi 5-10 menit.

## 0. Prasyarat (sekali saja)
- Laragon Full (sudah termasuk PHP 8.2+, MySQL, Composer).
- Pastikan ekstensi PHP aktif: **gd, fileinfo, pdo_mysql, pdo_sqlite, mbstring, openssl**.
  Laragon: **Menu -> PHP -> Extensions** -> centang yang belum aktif -> restart.

## 1. Taruh project
- Ekstrak `menusantara-laravel.zip` ke: `C:\laragon\www\menusantara`
  (sehingga ada `C:\laragon\www\menusantara\artisan`).
- Start Laragon -> **Start All**.

## 2. Buka terminal di folder project
- Laragon -> tombol **Terminal** (atau klik kanan project -> Terminal).
```bash
cd C:\laragon\www\menusantara
```

## 3. Install dependency Laravel
```bash
composer install
copy .env.example .env
php artisan key:generate
```

## 4. Siapkan database (pilih SALAH SATU)

### Opsi A - MySQL (disarankan, Laragon sudah ada MySQL)
1. Laragon -> **Menu -> MySQL -> ...** atau buka **HeidiSQL**, buat database baru: `menusantara`.
   (atau di terminal: `mysql -u root -e "CREATE DATABASE menusantara"`)
2. Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=menusantara
DB_USERNAME=root
DB_PASSWORD=
```
(Password root Laragon default kosong.)

### Opsi B - SQLite (paling cepat, tanpa buat DB)
```bash
type nul > database\database.sqlite
```
Biarkan `.env`: `DB_CONNECTION=sqlite` (default).

## 5. Pasang panel admin (Filament)
```bash
composer require filament/filament:"^3.2" -W
php artisan filament:install --panels
```
(Jika ditanya membuat provider, jawab Yes/Enter. Ini otomatis mengenali
semua menu admin yang sudah dibuat.)

## 6. Migrasi + data awal + storage
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
```

## 6b. Build tampilan front-end (Tailwind + Vite) - WAJIB
Desain baru memakai Tailwind + Vite. Tanpa langkah ini, situs memakai CSS lama sebagai fallback.
```bash
npm install
npm run build
```
Untuk mode pengembangan dengan hot-reload: `npm run dev` (biarkan berjalan sambil mengedit).

## 6c. Form reaktif tanpa reload (Livewire)
Semua form publik (Kontak Cepat, Kemitraan, Relawan, Daftar Program, Newsletter) otomatis menjadi
reaktif (kirim tanpa reload + validasi langsung) begitu Livewire terpasang.
- Livewire **sudah otomatis ikut terpasang** bersama Filament di Langkah 5 (Filament v3 memerlukannya),
  dan juga sudah tercantum di `composer.json`.
- Bila karena suatu hal belum ada, jalankan:
```bash
composer require livewire/livewire
php artisan optimize:clear
```
- Sebelum Livewire terpasang, form tetap berfungsi normal (mode kirim biasa dengan refresh).

## 7. Buka website
- Laragon otomatis membuat domain: **http://menusantara.test**
  (Laragon mengarahkan ke folder `public/` otomatis.)
- Jika domain .test tidak jalan: **Menu -> Reload** atau pakai:
  ```bash
  php artisan serve
  ```
  lalu buka http://127.0.0.1:8000

## 8. Masuk ke Admin
- URL: **http://menusantara.test/admin**
- Email: **admin@menusantara.org**
- Password: **admin123**
- Segera ganti password & tambah admin ke-2 di menu **Pengaturan -> Admin & Pengguna**.
- Ganti logo di **Pengaturan -> Logo & Identitas**.

---

## Troubleshooting cepat
| Gejala | Solusi |
|---|---|
| `could not find driver` | Aktifkan `pdo_mysql`/`pdo_sqlite` di Laragon PHP Extensions, restart |
| Gambar/logo tidak muncul | Jalankan `php artisan storage:link` |
| Halaman 419 / expired | `php artisan optimize:clear` lalu refresh |
| CSS berantakan | Pastikan akses via `http://menusantara.test` (bukan buka file .html) |
| `Class ... Controller not found` | Sudah diperbaiki (base Controller ada). Jalankan `composer dump-autoload` bila perlu |
| Domain .test tak terbuka | Laragon Menu -> Reload; atau pakai `php artisan serve` |
| Perlu jalankan test | `php artisan test` |
