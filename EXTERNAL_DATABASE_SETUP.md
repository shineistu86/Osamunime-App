# Konfigurasi Database Eksternal

## Panduan Menggunakan MySQL Eksternal

Aplikasi ini sekarang mendukung penggunaan database MySQL eksternal untuk deployment ke platform seperti Vercel. Ini penting karena Vercel menggunakan sistem serverless yang bersifat sementara (ephemeral), sehingga database lokal seperti SQLite tidak cocok karena datanya akan hilang setiap kali aplikasi tidak aktif.

## Konfigurasi Environment Variables

Untuk menggunakan database MySQL eksternal, atur variabel lingkungan berikut:

### Variabel Wajib:
- `EXTERNAL_DB_HOST` - Host dari database MySQL eksternal
- `EXTERNAL_DB_PORT` - Port dari database MySQL (default: 3306)
- `EXTERNAL_DB_DATABASE` - Nama database
- `EXTERNAL_DB_USERNAME` - Username untuk koneksi ke database
- `EXTERNAL_DB_PASSWORD` - Password untuk koneksi ke database

### Variabel Opsional:
- `EXTERNAL_MYSQL_ATTR_SSL_CA` - Path ke file SSL certificate authority jika database memerlukan koneksi SSL

## Cara Menggunakan

1. Buat akun di layanan database MySQL eksternal seperti:
   - Files.io
   - PlanetScale
   - Supabase (untuk PostgreSQL)
   - Neon.tech (untuk PostgreSQL)

2. Siapkan database dan dapatkan informasi koneksi (host, port, database name, username, password)

3. Atur variabel lingkungan di platform deployment Anda

4. Ubah `DB_CONNECTION` menjadi `external_mysql` di environment production

## Contoh Konfigurasi

Contoh untuk deployment ke Vercel:

```
DB_CONNECTION=external_mysql
EXTERNAL_DB_HOST=your-mysql-host.com
EXTERNAL_DB_PORT=3306
EXTERNAL_DB_DATABASE=your_database_name
EXTERNAL_DB_USERNAME=your_username
EXTERNAL_DB_PASSWORD=your_password
```

## Catatan Penting

- Pastikan database eksternal Anda siap menerima koneksi dari platform deployment Anda
- Jalankan migrasi database setelah menghubungkan ke database eksternal: `php artisan migrate`
- Jangan pernah hardcode informasi koneksi database di kode sumber
- Gunakan fitur environment variables dari platform deployment Anda