# Osamunime - Aplikasi Manajemen Anime Favorit

## Nama & NIM Mahasiswa

-   **Nama:** HISYAM EKA PRAMUDITA
-   **NIM:** 2307016

## Teknologi yang Digunakan

-   **Backend:** Laravel 12.x (PHP Framework)
-   **Frontend:** Bootstrap 5, JavaScript
-   **Database:** SQLite (lokal) / MySQL (produksi eksternal)
-   **API:** Jikan API (untuk data anime)
-   **Build Tool:** Vite
-   **Server:** Apache/Nginx
-   **Bahasa Pemrograman:** PHP 8.2+, JavaScript

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js dan npm
-   Database (SQLite untuk lokal, MySQL untuk produksi)

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
    cp .env.example .env
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

7. Jalankan migrasi database:
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

1. Jalankan server Laravel di terminal pertama:

    ```bash
    php artisan serve
    ```

2. Jalankan Vite watcher di terminal kedua:
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

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.
