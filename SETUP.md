# Yayasan TM Menusantara - Laravel App

Hasil migrasi penuh dari prototype `index.html` (SPA) menjadi aplikasi Laravel 12
yang scalable & maintainable (Blade multipage + MySQL/SQLite + panel Admin).

## Isi
- Website publik: Beranda, Tentang, Program, Berita (+ detail), Kemitraan,
  Transparansi Keuangan, Kontak (form -> tersimpan + auto WhatsApp).
- Panel Admin (`/admin`): Ringkasan, Data Masuk (leads), Keuangan, Berita,
  Pengaturan (kontak & ganti sandi). Login + logout.

## Cara pasang (lokal)

1. Buat project Laravel baru lalu timpa dengan file-file di bundle ini:
   ```bash
   composer create-project laravel/laravel menusantara
   cd menusantara
   ```
   Salin semua file dari bundle (lihat header `==== FILE: ... ====`) ke path
   yang sama. File yang perlu ditimpa/ditambah: `composer.json`,
   `bootstrap/app.php`, `routes/web.php`, `config/yayasan.php`, `app/**`,
   `database/migrations/**`, `database/seeders/DatabaseSeeder.php`,
   `resources/views/**`, `public/css/**`, `public/js/**`.

2. Autoload helper (sudah diset di composer.json bundle: `autoload.files`):
   ```bash
   composer dump-autoload
   ```

3. Konfigurasi database di `.env`.
   - SQLite cepat untuk lokal:
     ```
     DB_CONNECTION=sqlite
     ```
     lalu `touch database/database.sqlite`
   - MySQL (Hostinger): isi DB_HOST/DB_DATABASE/DB_USERNAME/DB_PASSWORD.

4. Migrasi + data awal:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. Jalankan:
   ```bash
   php artisan serve
   ```
   - Publik: http://127.0.0.1:8000
   - Admin: http://127.0.0.1:8000/admin/login
     user: `admin`  |  sandi: `admin123`  (ganti di menu Pengaturan)

## Deploy ke Hostinger (ringkas)
- Upload project, arahkan document root ke folder `public/`.
- Set `.env` (APP_ENV=production, APP_DEBUG=false, APP_URL, DB MySQL).
- `composer install --no-dev`, `php artisan migrate --seed --force`,
  `php artisan config:cache route:cache view:cache`.

## Catatan arsitektur
- CSS asli prototype dipertahankan utuh di `public/css/app.css` (tanpa diubah).
- Tema admin terpisah di `public/css/admin.css`.
- JS interaksi header/menu/reveal di `public/js/app.js`.
- Logika bisnis ada di Controllers; data di Models (News, Lead, Finance, Setting).
- Helper global: `rp()`, `fmt_date()`, `wa_link()`, `setting()` (app/helpers.php).

## Cara split bundle
File bundle `menusantara-laravel-bundle.txt` memisahkan tiap file dengan baris:
`/* ==== FILE: <path relatif> ==== */`
Salin blok di bawah tiap header ke path yang tertera untuk memecahnya kembali
menjadi struktur project aslinya.
