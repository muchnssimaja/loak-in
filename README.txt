LOAK.IN — Laravel MVP (Drop-in Pack)
Updated: 2025-10-27

Cara Pakai (5 menit):
1) Buat project Laravel baru
   composer create-project laravel/laravel loakin
   cd loakin

2) Pakai SQLite (opsional, paling cepat)
   - Buat file: database/database.sqlite
     (Windows)  copy NUL database\database.sqlite
     (Mac/Linux) touch database/database.sqlite
   - Edit .env:
     DB_CONNECTION=sqlite
     DB_DATABASE={absolute_path_ke_project}/database/database.sqlite

3) Buat storage link (untuk gambar upload)
   php artisan storage:link

4) Salin isi ZIP ini ke root project Laravel-mu (merge folder).

5) Migrasi & jalankan
   php artisan migrate
   php artisan serve
   Buka http://127.0.0.1:8000

Apa yang sudah ada:
- Landing page cantik (home) + navbar brand LOAK•IN
- CRUD minimal: create + index + show (upload foto)
- Desain responsif (Bootstrap 5 + custom CSS)
- Komponen siap kembangkan (kategori, search, dll.)

Struktur:
- routes/web.php
- app/Models/Listing.php
- app/Http/Controllers/ListingController.php
- database/migrations/*_create_listings_table.php
- resources/views/layouts/app.blade.php
- resources/views/home.blade.php
- resources/views/listings/index.blade.php
- resources/views/listings/create.blade.php
- resources/views/listings/show.blade.php
- public/assets/css/loakin.css
- public/assets/img/logo.svg

Catatan:
- Jika pakai MySQL, biarkan .env default dan isi DB_DATABASE/USER/PASS; lewati langkah SQLite.
- Kamu bisa ubah warna brand di public/assets/css/loakin.css
- Untuk auth (login/daftar), tambahkan Laravel Breeze nanti.
