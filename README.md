# Osamunime - Aplikasi Manajemen Anime Favorit

## Nama & NIM Mahasiswa

-   **Nama:** HISYAM EKA PRAMUDITA
-   **NIM:** 2307016

## Teknologi yang Digunakan

-   **Backend:** Laravel 12.x (PHP Framework)
-   **Frontend:** Bootstrap 5, JavaScript
-   **Database:** MySQL (lokal)
-   **API:** Jikan API (untuk data anime)
-   **Build Tool:** Vite
-   **Server:** PHP Built-in Server
-   **Bahasa Pemrograman:** PHP 8.2+, JavaScript

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js dan npm
-   MySQL (melalui Laragon/XAMPP)

### Instalasi

1. Clone repository ini:

    ```bash
    git clone <url-repository>
    cd Osamunime-App
    ```

2. Install dependensi PHP:

    ```bash
    composer install
    ```

3. Copy file environment dan atur konfigurasi:

    ```bash
    copy .env.example .env
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Install dependensi JavaScript:

    ```bash
    npm install
    ```

6. Build asset frontend:

    ```bash
    npm run build
    ```

7. Pastikan MySQL server (Laragon/XAMPP) sedang berjalan

8. Konfigurasi database MySQL di file .env (pastikan DB_CONNECTION=mysql, DB_HOST=127.0.0.1, DB_PORT=3306, DB_DATABASE=osamunime_db, DB_USERNAME=root, dan DB_PASSWORD sesuai dengan pengaturan MySQL Anda).

9. Jalankan migrasi database:
    ```bash
    php artisan migrate
    ```

### Menjalankan Aplikasi

1. Jalankan development server:

    ```bash
    php artisan serve
    ```

2. Buka browser dan akses `http://localhost:8000`

### Untuk Development (dengan hot reload)

1. Buka terminal/command prompt pertama dan jalankan server Laravel:

    ```bash
    php artisan serve
    ```

2. Buka terminal/command prompt kedua dan jalankan Vite watcher untuk hot reload CSS/JS:
    ```bash
    npm run dev
    ```

## Fitur Utama

-   Menampilkan daftar anime dari API eksternal (Jikan API)
-   Menyimpan anime sebagai favorit
-   Menambahkan rating dan review untuk anime favorit
-   Menyaring dan mengurutkan anime favorit
-   Sistem tagging untuk anime favorit
-   Responsive design untuk berbagai ukuran layar

## Tangkapan Layar (Screenshot)

### Halaman Utama
![Halaman Utama](screenshots/Halaman%20Utama.png)

### Detail Anime
![Detail Anime](screenshots/Detail%20Anime.png)

### Halaman My Favorite
![Halaman My Favorite](screenshots/Halaman%20My%20Favorite.png)

### Form Edit Favorite
![Form Edit Favorite](screenshots/Form%20Edit%20Favorite.png)

### Halaman Genre
![Halaman Genre](screenshots/Halaman%20Genre.png)

### Halaman Login
![Halaman Login](screenshots/Login.png)

### Halaman Register
![Halaman Register](screenshots/Register.png)

## Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan buat pull request untuk perubahan yang ingin ditambahkan.

## Catatan Penting untuk Penggunaan Aplikasi

Beberapa hal yang perlu diperhatikan agar aplikasi bisa digunakan sepenuhnya:

1. **Database lokal** - Aplikasi ini menggunakan MySQL sebagai database utama. Database yang digunakan bernama `osamunime_db` dan dapat diakses melalui phpMyAdmin.

2. **API Jikan** - Aplikasi ini menggunakan Jikan API untuk mengambil data anime. Tidak memerlukan API key, namun tergantung ketersediaan API.

3. **Koneksi internet** - Koneksi internet diperlukan untuk menampilkan informasi anime secara lengkap dari API.

4. **Akses database** - Data pengguna, favorit, dan tag dapat dilihat langsung di database `osamunime_db` melalui phpMyAdmin di `http://localhost/phpmyadmin`.

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.

## Akses Aplikasi

- **Aplikasi Web**: `http://localhost:8000`
- **Database (phpMyAdmin)**: `http://localhost/phpmyadmin` (database: `osamunime_db`)
- **API Jikan**: Otomatis digunakan untuk mengambil data anime dari `https://api.jikan.moe/v4`

## Deployment

Aplikasi ini saat ini dikonfigurasi untuk penggunaan lokal. Untuk deployment ke platform hosting produksi, konfigurasi database perlu disesuaikan dengan lingkungan produksi.
