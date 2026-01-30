# Osamunime - Aplikasi Manajemen Anime Favorit

## Nama & NIM Mahasiswa

-   **Nama:** HISYAM EKA PRAMUDITA
-   **NIM:** 2307016

## Teknologi yang Digunakan

-   **Backend:** Laravel 12.x (PHP Framework)
-   **Frontend:** Bootstrap 5, JavaScript
-   **Database:** SQLite (lokal) / MySQL (opsional)
-   **API:** Jikan API (untuk data anime)
-   **Build Tool:** Vite
-   **Server:** PHP Built-in Server
-   **Bahasa Pemrograman:** PHP 8.2+, JavaScript

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js dan npm

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

7. Jalankan migrasi database:
    ```bash
    php artisan migrate
    ```

8. Konfigurasi database SQLite di file .env (pastikan DB_CONNECTION=sqlite, dan hapus konfigurasi DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD atau sesuaikan dengan pengaturan lokal Anda).

9. Buat file database SQLite (jika belum ada):
    ```bash
    touch database/database.sqlite
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

Namun, ada beberapa hal yang perlu diperhatikan agar aplikasi bisa digunakan sepenuhnya:

1. **Database lokal** - Aplikasi ini sekarang dikonfigurasi untuk menggunakan MySQL sebagai database utama. Database yang digunakan bernama `osamunime_db` dan dapat diakses melalui phpMyAdmin.

2. **API key** - Aplikasi ini menggunakan Jikan API untuk mengambil data anime. Umumnya Jikan API tidak memerlukan API key untuk penggunaan dasar, namun pembatasan rate limit mungkin berlaku.

3. **Koneksi internet** - Karena aplikasi mengambil data dari API eksternal, koneksi internet diperlukan untuk menampilkan informasi anime secara lengkap.

4. **Akses database** - Untuk melihat data pengguna, favorit, dan tag secara langsung, Anda dapat mengakses database `osamunime_db` melalui phpMyAdmin di `http://localhost/phpmyadmin`.

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.

## Akses Aplikasi

- **Aplikasi Web**: `http://localhost:8000`
- **Database (phpMyAdmin)**: `http://localhost/phpmyadmin` (database: `osamunime_db`)
- **API Jikan**: Otomatis digunakan untuk mengambil data anime dari `https://api.jikan.moe/v4`

## Deployment

### Ke Heroku

Aplikasi ini dapat dideploy ke Heroku dengan mengikuti langkah-langkah berikut:

1. **Persiapan Awal (Local Development)**
   - Kloning Proyek: Mengunduh kode sumber aplikasi Laravel dari GitHub.
   - Akses Terminal: Menggunakan terminal untuk menjalankan perintah Heroku CLI dan Git.
   - Login Heroku: Melakukan autentikasi akun melalui perintah `heroku login`.

2. **Konfigurasi Lingkungan Heroku**
   - Pembuatan Aplikasi: Membuat wadah aplikasi baru di Heroku menggunakan perintah `heroku create`.
   - File Procfile: Sudah disertakan dalam proyek ini.
   - Pengaturan APP_KEY: Menghasilkan dan mengatur kunci aplikasi Laravel di Heroku agar aplikasi dapat berjalan dengan aman.

3. **Pengaturan Basis Data (MySQL)**
   - Add-on ClearDB: Mengintegrasikan basis data MySQL menggunakan add-on ClearDB MySQL.
   - Konfigurasi Variabel Lingkungan: Mengambil URL basis data dari Heroku dan memecahnya menjadi variabel-variabel seperti DB_HOST, DB_DATABASE, DB_USERNAME, dan DB_PASSWORD.
   - Migrasi Data: Menjalankan perintah `php artisan migrate` langsung di server Heroku untuk membuat tabel-tabel yang diperlukan.

4. **Proses Deployment**
   - Git Workflow: Menambahkan perubahan (git add), melakukan commit (git commit), dan mendorong kode ke server Heroku (git push heroku master).
   - Instalasi Dependensi: Heroku secara otomatis mendeteksi aplikasi PHP dan menginstal paket-paket yang diperlukan melalui Composer.

5. **Verifikasi Akhir**
   - Membuka Aplikasi: Mengakses aplikasi yang sudah live melalui URL Heroku.
   - Registrasi Akun: Mencoba fitur registrasi pada aplikasi Laravel yang sudah ter-deploy untuk memastikan koneksi basis data berjalan lancar.

### Langkah-langkah Deployment ke Heroku

1. Login ke Heroku:
   ```bash
   heroku login
   ```

2. Buat aplikasi baru:
   ```bash
   heroku create nama-aplikasi-anda
   ```

3. Tambahkan add-on ClearDB MySQL:
   ```bash
   heroku addons:create cleardb:ignite
   ```

4. Ambil URL database:
   ```bash
   heroku config | grep CLEARDB_DATABASE_URL
   ```

5. Set konfigurasi database di Heroku:
   ```bash
   heroku config:set DB_CONNECTION=mysql
   heroku config:set DB_HOST=hostname_dari_cleardb
   heroku config:set DB_DATABASE=nama_db_dari_cleardb
   heroku config:set DB_USERNAME=username_dari_cleardb
   heroku config:set DB_PASSWORD=password_dari_cleardb
   ```

6. Generate dan set APP_KEY:
   ```bash
   php artisan key:generate --show
   heroku config:set APP_KEY=isi_key_yang_muncul_tadi
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   ```

7. Push proyek ke Heroku:
   ```bash
   git add .
   git commit -m "Siap untuk deploy ke Heroku"
   git push heroku master
   ```

8. Jalankan migrasi database di server:
   ```bash
   heroku run php artisan migrate --force
   ```

9. Buka aplikasi:
   ```bash
   heroku open
   ```

Catatan: Jika Anda menggunakan branch 'main' sebagai default, ganti 'master' dengan 'main' dalam perintah push.
