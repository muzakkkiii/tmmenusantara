# Panduan Pasang Panel Admin Filament

Proyek ini sekarang memakai **Filament** sebagai panel admin (menggantikan admin custom lama).
Panel berada di `/admin`. Ikuti langkah di bawah **satu kali** setelah meng-ekstrak file.

## 1. Install paket Filament

Jalankan di root proyek (folder yang ada `artisan`):

```bash
composer require filament/filament:"^3.2" -W
```

> Catatan: kalau composer menolak karena versi Laravel, coba tanpa versi:
> `composer require filament/filament -W` (composer akan memilih versi yang cocok).

## 2. Pasang panel + aset

```bash
php artisan filament:install --panels
```

Saat ditanya nama panel, ketik: **admin** (default). Perintah ini otomatis membuat
`app/Providers/Filament/AdminPanelProvider.php` (path `/admin`, auto-discovery) dan
mendaftarkannya di `bootstrap/providers.php`, lalu mem-publish aset CSS/JS Filament.

Semua Resource yang sudah saya siapkan (Berita, Data Masuk, Keuangan, Pengaturan)
dan widget statistik **otomatis terdeteksi** karena berada di `app/Filament/...`.

## 3. Migrasi tabel users + link storage

```bash
php artisan migrate
php artisan storage:link
```

- `migrate` menambahkan tabel `users` (untuk login panel).
- `storage:link` membuat symlink `public/storage` agar gambar berita hasil upload tampil.

## 4. Buat akun admin

Pilih salah satu:

**a) Pakai seeder (akun default):**
```bash
php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder
```
Login: `admin@menusantara.org` / `admin123`

**b) Atau buat manual (interaktif):**
```bash
php artisan make:filament-user
```

## 5. Bersihkan cache & jalankan

```bash
php artisan optimize:clear
php artisan serve
```

Buka: **http://menusantara.test/admin** (atau http://127.0.0.1:8000/admin)

---

## Kalau mulai dari database kosong

Cukup:
```bash
php artisan migrate:fresh --seed
```
Ini membuat semua tabel + akun admin + data contoh sekaligus.

## Yang berubah dibanding versi sebelumnya

- Panel admin custom lama (`/admin/login`, controller `Admin/*`, view `admin/*`,
  middleware `AdminAuth`) **dihapus** dan digantikan Filament.
- Model `User` + tabel `users` ditambahkan untuk otentikasi Filament.
- Gambar berita kini diunggah lewat Filament ke disk `public` (folder `storage/app/public/news`),
  ditampilkan via `storage:link`. URL gambar eksternal (https://...) tetap didukung.
- Link "Masuk Admin" di footer sekarang mengarah ke `/admin`.

## Opsional (kalau mau)

- Ubah warna brand & logo: edit `app/Providers/Filament/AdminPanelProvider.php`
  (mis. `->brandName('TM Menusantara')`, `->colors([...])`).
- Aktifkan halaman profil/ubah password: tambahkan `->profile()` pada provider tsb.
- Export CSV Data Masuk/Keuangan: bisa ditambah dengan `filament/actions` (ExportAction).

---

# Modul Donasi (Manual)

Halaman publik: **/donasi** (link "Donasi" sudah ada di menu navigasi).

Alur:
1. Donatur transfer ke rekening / QRIS yang tampil, lalu mengisi form konfirmasi
   (nama, nominal, peruntukan, metode, bukti transfer opsional).
2. Data masuk ke menu **Donasi** di panel admin dengan status "Menunggu Verifikasi".
3. Admin klik **Verifikasi** -> status jadi "Terverifikasi" DAN otomatis tercatat
   sebagai dana masuk di menu **Keuangan** (masuk ke laporan transparansi).

Pengaturan (edit `config/donasi.php`):
- `banks`   : daftar rekening tujuan.
- `qris`    : path gambar QRIS. Taruh file di **public/img/qris.png**
              (jika belum ada, blok QRIS otomatis disembunyikan).
- `gateway` : placeholder pembayaran online (Midtrans/Xendit) untuk nanti.

Wajib jalankan (menambah tabel donations):
```bash
php artisan migrate
```

Bukti transfer diunggah ke **public/uploads/bukti** (tanpa perlu storage:link).

---

# Fitur Lanjutan (SEO tambahan, Gambar, Konten, Notif, Backup)

## 1. Kompres/resize gambar otomatis
- Berita (panel admin): gambar otomatis dipangkas 16:9 (1200x675) & dikompres di browser saat upload.
- Bukti donasi (form publik): otomatis diperkecil (maks lebar 1400px, kualitas 78) via GD.
  Pastikan ekstensi PHP GD aktif (Laragon: sudah aktif secara default).

## 2. Konten dinamis (Tentang & Program)
Teks hero + paragraf utama Tentang, dan hero + tag/judul tiap Program kini bisa diedit
tanpa ngoding lewat menu **Pengaturan** di panel admin (baris berawalan `tentang_` dan
`program_`/`prog#_`). Untuk mengisi nilai awal (agar muncul di daftar Pengaturan):
```bash
php artisan db:seed --class=Database\\Seeders\\ContentSeeder
```
(idempoten: tidak menimpa nilai yang sudah Anda ubah).

## 3. Notifikasi email otomatis ke admin
- Saat ada **lead** atau **donasi** baru, email dikirim ke alamat pada Pengaturan `email`.
- Default mailer = `log` (email tersimpan di `storage/logs/laravel.log`) agar tidak error
  sebelum SMTP diatur. Untuk kirim sungguhan, isi `MAIL_*` di `.env` lalu `MAIL_MAILER=smtp`.
- Catatan WA: notifikasi WhatsApp masih semi-otomatis (tombol konfirmasi). WA yang benar-benar
  otomatis butuh WhatsApp Business API / gateway (bisa ditambah menyusul).

## 4. Backup rutin database
Jalankan manual kapan saja:
```bash
php artisan backup:db
```
Hasil di `storage/app/backups` (SQLite: copy .sqlite, MySQL: mysqldump .sql), menyimpan 14 terbaru.
Agar otomatis harian (02:00), tambahkan cron di server:
```
* * * * * cd /path/ke/proyek && php artisan schedule:run >> /dev/null 2>&1
```

## 5. Keamanan produksi (langkah deploy)
- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domainanda` di `.env`.
- HTTPS: aktifkan SSL gratis di panel hosting (Hostinger: SSL/Let's Encrypt), lalu paksa https.


---

## Fitur Lengkap Sesuai Spesifikasi Klien (Bab 11)

### 11.1 Fitur Wajib
- Profil Yayasan, Visi & Misi, Struktur Organisasi -> halaman /tentang (konten bisa diedit dari admin > Pengaturan).
- Program Yayasan -> /program.
- Berita & Kegiatan -> /berita (kelola di admin > Konten > Berita).
- Galeri Foto -> /galeri (kelola di admin > Konten > Galeri Foto, upload foto otomatis dikompres).
- Kontak WhatsApp -> tombol & link WA di seluruh halaman + /kontak.
- Form Kemitraan -> /mitra (masuk ke admin > Manajemen > Kemitraan).
- Download Proposal -> tombol di /kemitraan & footer. File: public/files/proposal.pdf (GANTI dengan proposal resmi Anda).
- Tampilan mobile friendly -> responsif (sudah ada sejak versi awal).

### 11.2 Fitur Lanjutan
- Form pendaftaran peserta -> /daftar (admin > Manajemen > Pendaftar Peserta, ada Export CSV).
- Database anggota/relawan -> /gabung (admin > Manajemen > Anggota & Relawan, ada Export CSV).
- Donasi online -> /donasi. Mode MANUAL (transfer/QRIS/tunai) aktif secara default.
  Mode ONLINE via Midtrans Snap: set di .env lalu DONASI_GATEWAY=true (lihat di bawah).
- Dashboard admin -> /admin (Filament) dengan 8 kartu statistik ringkas.
- Kalender kegiatan -> /agenda (admin > Konten > Agenda Kegiatan).
- Sertifikat pelatihan -> verifikasi publik /sertifikat/{kode}, bisa dicetak/PDF (admin > Konten > Sertifikat).
- Newsletter -> form langganan di footer; kelola & kirim broadcast di admin > Manajemen > Newsletter (tombol "Kirim Newsletter").
- Sistem laporan kegiatan -> /laporan-kegiatan (admin > Konten > Laporan Kegiatan).

## Langkah Setelah Menarik Update Ini
1. `php artisan migrate`  (membuat 8 tabel baru: galleries, partners, participants, members, events, certificates, subscribers, activity_reports)
2. `php artisan db:seed --class=Database\Seeders\FeatureDemoSeeder`  (opsional: isi data contoh galeri/agenda/laporan/sertifikat)
3. `php artisan storage:link`  (wajib agar upload foto Galeri/Laporan tampil di /storage/...)
4. `php artisan optimize:clear`

## Mengaktifkan Donasi Online (Midtrans)
Tambahkan di .env, lalu clear cache:
```
DONASI_GATEWAY=true
DONASI_PROVIDER=midtrans
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxx
MIDTRANS_PRODUCTION=false
```
- Set URL notifikasi (webhook) di dashboard Midtrans ke: `https://domain-anda/donasi/callback`
- Selama DONASI_GATEWAY=false, alur donasi tetap manual dan tombol "Bayar Online" tidak muncul.
- Callback memverifikasi signature SHA512 dan otomatis mencatat donasi terverifikasi ke laporan transparansi.

## Catatan Export CSV
Menu Kemitraan, Pendaftar Peserta, Anggota & Relawan, dan Newsletter punya tombol "Export CSV" (UTF-8 BOM, siap dibuka di Excel).
