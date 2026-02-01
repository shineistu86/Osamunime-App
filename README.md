# Osamunime - Aplikasi Manajemen Anime Favorit

## Deskripsi Aplikasi

Osamunime adalah aplikasi web yang memungkinkan pengguna untuk mencari, menyimpan, dan mengelola daftar anime favorit mereka. Aplikasi ini menyediakan antarmuka yang intuitif untuk menavigasi berbagai judul anime, menyimpannya ke daftar favorit, serta memberikan rating dan ulasan.

## Nama & NIM Mahasiswa

-   **Nama:** HISYAM EKA PRAMUDITA
-   **NIM:** 2307016

## Teknologi yang Digunakan

-   **Backend:** Laravel 12.x (PHP Framework)
-   **Frontend:** Tailwind CSS v4, JavaScript, Bootstrap 5
-   **Database:** MySQL (lokal) - menyimpan data pengguna, anime favorit, rating, review, dan tag
-   **API:** Jikan API (untuk data anime eksternal)
-   **Build Tool:** Vite
-   **Server:** PHP Built-in Server
-   **Bahasa Pemrograman:** PHP 8.2+, JavaScript, CSS

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js dan npm
-   MySQL (melalui Laragon/XAMPP)

### Instalasi

1. Clone repository ini:

    ```bash
    git clone https://github.com/shineistu86/Osamunime-App.git
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
-   Fitur pencarian dan filter berdasarkan genre
-   Antarmuka yang responsif untuk berbagai ukuran layar
-   Mode gelap (dark mode) untuk kenyamanan penggunaan jangka panjang

## Cara Menggunakan Aplikasi

1. **Registrasi Akun**:
   - Kunjungi halaman `/register` untuk membuat akun baru
   - Data user (nama, email, password) akan disimpan ke tabel `users` di database MySQL
   - Password akan di-hash untuk keamanan

2. **Login**:
   - Setelah registrasi, gunakan halaman `/login` untuk masuk
   - Session login akan disimpan di tabel `sessions` di database

3. **Mencari Anime**:
   - Gunakan kolom pencarian di halaman utama untuk mencari judul anime dari API Jikan
   - Hasil pencarian akan ditampilkan dalam bentuk kartu-kartu anime

4. **Melihat Detail**:
   - Klik pada kartu anime untuk melihat detail lengkap termasuk deskripsi, rating, jumlah episode, dll.

5. **Menyimpan Favorit**:
   - Klik tombol "Add to Favorites" di halaman detail anime
   - Data anime favorit akan disimpan ke tabel `favorites` di database MySQL
   - Anda bisa menambahkan rating dan review pada anime tersebut

6. **Mengelola Favorit**:
   - Kunjungi halaman "My Favorites" untuk melihat, mengedit, atau menghapus anime favorit
   - Di halaman ini Anda bisa mengedit rating, review, status penonton (misalnya: watching, completed, on hold, dll.), dan catatan tambahan

7. **Tagging**:
   - Anda bisa menambahkan tag ke anime favorit untuk mengategorinya
   - Tag disimpan di tabel `tags` dan hubungan antara favorite dan tag disimpan di tabel `favorite_tag`

8. **Filter dan Sortir**:
   - Gunakan fitur filter untuk menyaring anime favorit berdasarkan rating, abjad, status, dll.
   - Anda juga bisa menyortir berdasarkan berbagai kriteria

9. **Mode Gelap**:
   - Aktifkan mode gelap menggunakan toggle di pojok kanan atas untuk kenyamanan penggunaan jangka panjang

10. **Logout**:
   - Gunakan tombol logout di menu navigasi untuk keluar dari akun

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

## Struktur Database

Aplikasi ini menggunakan beberapa tabel di database MySQL untuk menyimpan berbagai jenis data:

-   **`users`**: Menyimpan informasi akun pengguna (nama, email, password terenkripsi)
-   **`favorites`**: Menyimpan daftar anime favorit pengguna beserta rating, review, dan status penonton
-   **`tags`**: Menyimpan tag-tag yang dapat diberikan ke anime favorit
-   **`favorite_tag`**: Tabel pivot yang menghubungkan antara anime favorit dan tag-tag yang diberikan
-   **`sessions`**: Menyimpan informasi session login pengguna
-   **`migrations`**: Melacak migrasi database yang telah dijalankan
-   **`cache`**: Tabel opsional untuk caching (jika diaktifkan)

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.

## Akses Aplikasi

- **Aplikasi Web**: `http://localhost:8000`
- **Database (phpMyAdmin)**: `http://localhost/phpmyadmin` (database: `osamunime_db`)
- **API Jikan**: Otomatis digunakan untuk mengambil data anime dari `https://api.jikan.moe/v4`

## Deployment

Aplikasi ini saat ini dikonfigurasi untuk penggunaan lokal. Untuk deployment ke platform hosting produksi, konfigurasi database perlu disesuaikan dengan lingkungan produksi.
