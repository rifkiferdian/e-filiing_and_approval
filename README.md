# SIASEPP KECe / E-Filling Arsip Surat

SIASEPP KECe adalah aplikasi e-filling berbasis CodeIgniter 3 untuk pengelolaan arsip surat, disposisi, approval naskah keluar, dan approval dokumen PDF dengan QR verifikasi publik.

Repository ini berisi aplikasi PHP, schema database awal, script update database, asset frontend, serta library PDF yang dipakai untuk membuat dokumen final ber-QR.

## Fitur Utama

- Autentikasi user dan manajemen role.
- Master data indeks surat, unit kerja, user, dan aplikasi.
- Registrasi surat masuk dan surat keluar.
- Disposisi surat masuk antar pejabat/unit kerja.
- Monitoring dan histori naskah.
- Template approval untuk naskah keluar.
- Approval naskah keluar.
- Dokumen Approval:
  - konfigurasi flow approval bertahap,
  - pengajuan dokumen PDF,
  - daftar dokumen yang perlu direview,
  - approve, reject, dan request revision,
  - laporan semua pengajuan,
  - QR verifikasi publik,
  - final PDF dengan QR verifikasi,
  - scan QR dokumen.
- Dashboard:
  - rekap surat masuk, surat keluar, dan disposisi,
  - grafik surat masuk vs surat keluar,
  - summary jumlah surat per tahun,
  - rekap Dokumen Approval per user login.

## Teknologi

- PHP / CodeIgniter 3
- MySQL atau MariaDB
- jQuery, Bootstrap/AdminLTE, DataTables, Chart.js
- Composer
- `setasign/fpdf`
- `setasign/fpdi`
- `html5-qrcode` untuk scan QR dari browser

## Requirement Server

Minimum yang direkomendasikan:

- PHP 8.1 sampai 8.4
- MySQL 5.7+ atau MariaDB 10.3+
- Apache dengan `mod_rewrite` aktif
- Composer
- Web server user punya akses tulis ke folder upload dan session/cache

Extension PHP yang perlu tersedia:

- `mysqli`
- `mbstring`
- `gd`
- `fileinfo`
- `openssl`
- `json`
- `zip`
- `curl` atau `allow_url_fopen` aktif untuk generate QR melalui API eksternal

Catatan PHP 8.4:

- Kode aplikasi utama memakai syntax yang kompatibel dengan PHP 8.x.
- Karena framework dasarnya CodeIgniter 3, PHP 8.4 mungkin menampilkan warning/deprecation dari core framework atau library lama pada konfigurasi error reporting yang sangat ketat.
- Uji khusus fitur login, upload dokumen, approval, generate QR, final PDF, dan halaman verifikasi setelah deploy ke PHP 8.4.

## Struktur Folder Penting

```text
application/
  config/                 Konfigurasi CodeIgniter
  controllers/            Controller aplikasi
  helpers/                Helper tambahan, termasuk fallback PDF stamp
  models/                 Model database
  views/                  View halaman aplikasi

assets/
  dist/                   Asset template dan logo
  dokumen_approval/       Upload PDF dokumen approval
  dokumen_approval/final/ PDF final dengan QR
  dokumen_approval/qrcode/ File QR code
  surat_masuk/            Upload surat masuk
  surat_keluar/           Upload surat keluar

database_updates/         Script update schema tambahan
vendor/                   Dependency Composer
distanna_arsip.sql        Dump database awal
```

## Instalasi Lokal

Contoh setup memakai XAMPP:

1. Clone atau copy project ke folder web server:

   ```bash
   C:\xampp\htdocs\efilling
   ```

2. Install dependency Composer:

   ```bash
   composer install
   ```

3. Buat database MySQL, misalnya:

   ```sql
   CREATE DATABASE `e-filling` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```

4. Import database awal:

   ```bash
   mysql -u root -p e-filling < distanna_arsip.sql
   ```

5. Jalankan script update database sesuai urutan tanggal:

   ```bash
   mysql -u root -p e-filling < database_updates/2026_06_18_histori_naskah.sql
   mysql -u root -p e-filling < database_updates/2026_06_18_approval_naskah_keluar.sql
   mysql -u root -p e-filling < database_updates/2026_06_20_dokumen_approval.sql
   mysql -u root -p e-filling < database_updates/2026_06_20_dokumen_approval_mandiri.sql
   ```

6. Atur koneksi database di:

   ```text
   application/config/database.php
   ```

   Contoh:

   ```php
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'e-filling',
   'dbdriver' => 'mysqli',
   ```

7. Atur `base_url` di:

   ```text
   application/config/config.php
   ```

   Contoh lokal:

   ```php
   $config['base_url'] = 'http://localhost/efilling/';
   ```

8. Pastikan folder upload bisa ditulis:

   ```text
   assets/surat_masuk/
   assets/surat_keluar/
   assets/dokumen_approval/
   assets/dokumen_approval/final/
   assets/dokumen_approval/qrcode/
   application/cache/
   application/logs/
   ```

9. Buka aplikasi:

   ```text
   http://localhost/efilling/
   ```

## Konfigurasi Penting

### Base URL

Pastikan `application/config/config.php` memakai URL domain server yang benar. Contoh production:

```php
$config['base_url'] = 'https://domain-anda.ac.id/efilling/';
```

Jika aplikasi dipasang di root domain:

```php
$config['base_url'] = 'https://domain-anda.ac.id/';
```

### Index Page dan Rewrite

Saat `index_page` kosong:

```php
$config['index_page'] = '';
```

Apache perlu mendukung rewrite agar URL tanpa `index.php` berjalan. Jika rewrite belum aktif, set sementara:

```php
$config['index_page'] = 'index.php';
```

### Session

Project memakai session database:

```php
$config['sess_driver'] = 'database';
```

Pastikan tabel `ci_sessions` tersedia dari dump database awal. Jika session sering logout sendiri, cek permission folder, konfigurasi cookie, dan domain `base_url`.

### Composer dan PDF

Fitur final PDF Dokumen Approval membutuhkan:

```text
vendor/autoload.php
```

Jalankan `composer install` di server jika folder `vendor/` tidak ikut dideploy.

## Modul Dokumen Approval

Alur umum:

1. Admin membuat flow approval di menu Dokumen Approval > Flow Approval.
2. User mengajukan dokumen PDF di menu Pengajuan.
3. Reviewer membuka menu Approval Saya.
4. Reviewer melakukan approve, reject, atau request revision.
5. Jika semua step selesai dan approved, sistem membuat QR verifikasi.
6. Sistem membuat final PDF dengan QR pada halaman pertama.
7. QR dapat dibuka melalui halaman verifikasi publik:

   ```text
   /dashboard/verifikasi_doc_approval/{token}
   ```

Folder yang dipakai:

```text
assets/dokumen_approval/         File PDF asli
assets/dokumen_approval/qrcode/  File QR PNG
assets/dokumen_approval/final/   File PDF final dengan QR
```

Catatan:

- QR dibuat menggunakan API `https://api.qrserver.com`. Server perlu akses internet atau mekanisme QR lokal perlu disiapkan.
- Logo tengah QR memakai `assets/dist/img/logo_ww.png` dan membutuhkan extension `gd`.
- Jika FPDI gagal membuat final PDF, aplikasi mencoba fallback Python melalui `application/helpers/doc_approval_pdf_stamp.py`.

## Dashboard

Dashboard menampilkan:

- kartu total surat masuk, surat keluar, dan disposisi,
- grafik mutasi surat masuk vs surat keluar,
- pie chart summary surat per tahun,
- rekap Dokumen Approval Saya.

Rekap Dokumen Approval difilter berdasarkan user login:

- Pengajuan Saya: dokumen yang dibuat user.
- Perlu Saya Review: dokumen aktif yang sedang menunggu aksi user.
- Disetujui: dokumen user yang sudah approved.
- Ditolak / Revisi: dokumen user yang rejected atau revision required.
- Dokumen Approval Terbaru Terkait Saya: dokumen yang user ajukan, review, atau pernah proses.

## Deployment ke Server

Checklist deployment:

1. Upload source aplikasi.
2. Jalankan `composer install --no-dev` di server.
3. Import database awal dan semua script update database.
4. Sesuaikan `application/config/database.php`.
5. Sesuaikan `application/config/config.php`, terutama `base_url`.
6. Pastikan folder upload dan logs writable oleh user web server.
7. Pastikan extension PHP yang dibutuhkan aktif.
8. Pastikan server bisa mengakses API QR jika fitur QR dipakai.
9. Test login, dashboard, upload surat, disposisi, approval naskah keluar, Dokumen Approval, final PDF, dan verifikasi QR.

Contoh permission Linux:

```bash
chmod -R 775 application/cache application/logs assets/surat_masuk assets/surat_keluar assets/dokumen_approval
chown -R www-data:www-data application/cache application/logs assets/surat_masuk assets/surat_keluar assets/dokumen_approval
```

Sesuaikan `www-data` dengan user web server yang dipakai.

## File yang Tidak Disimpan ke Git

Beberapa file/folder memang di-ignore:

- `application/config/database.php`
- `vendor/`
- file upload surat masuk
- file upload surat keluar
- file upload Dokumen Approval, final PDF, dan QR
- cache dan logs

Saat pindah server, siapkan ulang file konfigurasi dan jalankan Composer.

## Troubleshooting

### Halaman 404 setelah deploy

- Cek `base_url`.
- Cek `.htaccess` dan `mod_rewrite`.
- Jika perlu, ubah sementara `$config['index_page'] = 'index.php';`.

### Tidak bisa upload file

- Cek permission folder upload.
- Cek `upload_max_filesize` dan `post_max_size` di `php.ini`.
- Cek extension `fileinfo`.

### QR tidak muncul

- Pastikan server bisa akses internet ke `api.qrserver.com`.
- Pastikan folder `assets/dokumen_approval/qrcode/` writable.
- Pastikan extension `gd` aktif jika logo QR ingin ditempel.

### PDF final tidak dibuat

- Jalankan `composer install`.
- Pastikan `vendor/autoload.php` tersedia.
- Pastikan `setasign/fpdf` dan `setasign/fpdi` terinstall.
- Pastikan folder `assets/dokumen_approval/final/` writable.
- Cek `application/logs/` untuk pesan error.

### User sering logout

- Cek tabel `ci_sessions`.
- Cek konfigurasi session di `application/config/config.php`.
- Cek cookie domain/path jika aplikasi dipasang di subfolder.

## Catatan Pengembangan

- Gunakan `rg` atau pencarian cepat untuk menemukan controller/view terkait.
- Halaman dashboard utama ada di:

  ```text
  application/views/dashboard/dashboard.php
  ```

- Controller utama sebagian besar berada di:

  ```text
  application/controllers/Dashboard.php
  ```

- Script database tambahan berada di:

  ```text
  database_updates/
  ```

## Lisensi

Project ini berbasis CodeIgniter yang menggunakan lisensi MIT. Untuk penggunaan internal, perhatikan juga lisensi dependency Composer dan asset frontend yang disertakan.
