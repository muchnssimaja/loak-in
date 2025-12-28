# LOAK.IN  
_Aplikasi Website Jual Beli Barang Bekas Berbasis Laravel_

---

## 📌 Deskripsi Project

LOAK.IN adalah sebuah aplikasi website marketplace yang dirancang khusus untuk memfasilitasi proses jual beli barang bekas secara online. Aplikasi ini memungkinkan pengguna untuk membuat listing barang, melihat detail produk, serta melakukan pengelolaan listing melalui dashboard admin.

Project ini dikembangkan menggunakan framework Laravel sebagai bagian dari implementasi pemrograman web lanjutan dengan menerapkan arsitektur Model-View-Controller (MVC), sistem autentikasi pengguna, serta pengelolaan database relasional.

LOAK.IN bertujuan untuk memberikan solusi sederhana, terstruktur, dan mudah digunakan bagi pengguna yang ingin menjual maupun mengelola barang bekas secara digital.

---

## 🎯 Fitur Utama

### 👤 Pengguna
- Registrasi dan Login
- Membuat listing barang
- Upload foto produk
- Edit dan hapus listing
- Melihat semua listing yang tersedia

### 🛠 Admin
- Dashboard laporan listing
- Melihat status listing (Baru, Diproses, Selesai)
- Mengelola data listing
- Mengelola kategori

---

## 🧱 Teknologi yang Digunakan

- **Framework**: Laravel 12
- **Bahasa Pemrograman**: PHP 8.2
- **Database**: MySQL / SQLite
- **Frontend**: HTML, CSS, JavaScript
- **UI Framework**: Bootstrap / Tailwind CSS
- **Version Control**: Git & GitHub
- **Web Server**: Apache (XAMPP)

---

## 🏗 Arsitektur Sistem

Aplikasi ini menggunakan arsitektur **MVC (Model–View–Controller)**:
- **Model**: Mengelola data dan relasi database
- **View**: Antarmuka pengguna (Blade Template)
- **Controller**: Logika bisnis dan alur aplikasi

---

## ⚙️ Cara Instalasi & Menjalankan Project
```bash
1️⃣ Clone Repository
git clone https://github.com/muchnssimaja/loak-in.git

2️⃣ Masuk ke Folder Project
cd loak-in

3️⃣ Install Dependency
composer install

4️⃣ Copy File Environment
cp .env.example .env

5️⃣ Generate App Key
php artisan key:generate

6️⃣ Konfigurasi Database

Edit file .env:

DB_DATABASE=loak_in
DB_USERNAME=root
DB_PASSWORD=

7️⃣ Migrasi Database
php artisan migrate

8️⃣ Jalankan Server
php artisan serve


Akses aplikasi di:

http://127.0.0.1:8000

🧪 Akun Default (Jika Ada Seeder)
admin@loak-in.test
password123

📂 Struktur Folder Penting
app/
 ├── Models
 ├── Http/Controllers
resources/
 ├── views
routes/
 ├── web.php
database/
 ├── migrations
