# Proyek Laravel 11

Ini adalah proyek Laravel 11. Panduan ini menjelaskan cara menjalankan proyek dari GitHub.

## Prerequisites

Sebelum memulai, pastikan Anda memiliki perangkat lunak berikut yang terinstal di sistem Anda:

- [PHP](https://www.php.net/) (versi 8.1 atau yang lebih baru)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) atau database lainnya yang didukung

## Langkah-langkah

### 1. Clone Repository

Clone repository Laravel ke direktori lokal Anda dengan perintah:

```bash
git clone https://github.com/username/repository.git
```

### 2. Navigasi Ke Direktori Proyek

Masuk ke direktori proyek yang telah di-clone:

```bash
cd (nama_repository)
```

### 3. Install Dependencies

Install dependensi PHP dengan Composer:

```bash
composer install
```

### 4. Setup File Environment

Salin file .env.example menjadi file .env:

```bash
cp .env.example .env
``` 

### 5. Generate Application Key

Generate key aplikasi Laravel:

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buka file .env dan atur konfigurasi database sesuai dengan ini:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo-apps
DB_USERNAME=user_database
DB_PASSWORD=password_database
```

### 7. Migrate Database

Jalankan migrasi database untuk menyiapkan struktur tabel:

```bash
php artisan migrate
```

Jalankan Seeder untuk mengisi data awal

```bash
php artisan db:seed
```

### 10. Jalankan Server Laravel

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

### Troubleshooting

Jika Anda mengalami masalah, pastikan untuk memeriksa:

1. XAMPP atau server lokal Anda sudah berjalan dan modul Apache serta MySQL aktif.
2. File .env sudah dikonfigurasi dengan benar.
3. Semua dependensi telah diinstal dengan benar.
4. Versi PHP dan MySQL yang digunakan sesuai dengan yang dibutuhkan oleh proyek.


