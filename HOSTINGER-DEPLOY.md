# Panduan Deploy ke Hostinger (MySQL)

Website ini **100% kompatibel MySQL** dan siap di-hosting di Hostinger.
Untuk pengembangan lokal (Laragon) default-nya SQLite agar praktis, tetapi di
produksi cukup ganti beberapa baris `.env` ke MySQL — tanpa mengubah kode.

---

## A. Siapkan Database MySQL di hPanel

1. Login **hPanel Hostinger** -> menu **Databases -> MySQL Databases**.
2. Buat database baru, mis. `u123456_menusantara`.
3. Buat user + password, lalu **Add user to database** dengan **ALL PRIVILEGES**.
4. Catat: nama database, username, password, dan host (biasanya `localhost`).

## B. Upload Kode

**Opsi 1 - Git (disarankan bila plan mendukung SSH):**
```bash
cd ~/domains/domainanda.com
git clone <repo> app && cd app
composer install --no-dev --optimize-autoloader
```

**Opsi 2 - Upload ZIP via File Manager:**
1. Upload `menusantara-laravel.zip` -> Extract.
2. Jalankan `composer install --no-dev --optimize-autoloader`
   (Hostinger: menu **Advanced -> SSH** atau **Composer** di hPanel).

## C. Arahkan Domain ke folder `public`

Laravel HARUS menunjuk ke folder `public/`, bukan root project.
- hPanel -> **Domains -> Manage -> Document Root** -> set ke `.../app/public`.
- Alternatif (jika document root wajib `public_html`): pindahkan isi `public/`
  ke `public_html/`, lalu edit `public_html/index.php` agar path `require`
  menunjuk ke folder project (`__DIR__.'/../app/vendor/autoload.php'`, dst).

## D. Konfigurasi `.env`

```env
APP_NAME="Yayasan TM Menusantara"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456_menusantara
DB_USERNAME=u123456_admin
DB_PASSWORD=passwordkuat

FILESYSTEM_DISK=public
MAIL_MAILER=smtp   # isi SMTP Hostinger untuk email notifikasi
```

## E. Inisialisasi Aplikasi (jalankan via SSH / Terminal hPanel)

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force        # data awal + akun admin + konten
php artisan storage:link           # agar gambar/logo upload tampil
php artisan optimize               # cache config/route/view
```

Login admin awal: **admin@menusantara.org / admin123** (segera ganti via menu
"Admin & Pengguna").

## F. Wajib Sebelum Go-Live

- [ ] Aktifkan **SSL** (hPanel -> SSL, gratis Let's Encrypt) -> pastikan HTTPS.
- [ ] `APP_DEBUG=false` (sudah di atas).
- [ ] Ganti password admin default & buat admin ke-2.
- [ ] Upload logo asli via **Admin -> Pengaturan -> Logo & Identitas**.
- [ ] Isi kontak/WA/alamat & nomor rekening donasi.
- [ ] (Opsional) Aktifkan cron **Scheduler** di hPanel bila memakai tugas terjadwal:
      `php /path/app/artisan schedule:run` tiap 1 menit.

## G. Migrasi Data dari SQLite lokal -> MySQL (opsional)

Karena skema identik, cukup jalankan ulang `migrate --force` + `db:seed --force`
di server. Bila ingin memindahkan data yang sudah ada, ekspor per-tabel dari
lokal lalu import via phpMyAdmin Hostinger.

---

### Ringkas: kenapa mudah di Hostinger?
- Framework Laravel 12 standar (didukung penuh Hostinger, PHP 8.2+).
- Tanpa build front-end wajib (CSS/JS statis sudah ada di `public/`).
- Ganti DB cukup lewat `.env` — **tidak menyentuh kode**.
- Semua langkah pakai perintah artisan standar.
