# Smart POS Terminal - Arsitektur Cloud Services

Aplikasi Point of Sales (POS) sederhana berbasis container untuk mengelola pesanan dengan custom modifier, dilengkapi antarmuka kasir dan endpoint API JSON.

## Prasyarat
- Docker Desktop
- Terminal (PowerShell/CMD/Git Bash)

## Langkah Menjalankan Aplikasi
1. Buka terminal di dalam direktori proyek ini.
2. Pastikan file `.env.example` sudah disesuaikan (atau gunakan langsung sebagai referensi environment).
3. Jalankan perintah: `docker-compose up -d --build`
4. Tunggu hingga proses *pull image* dan inisialisasi database (otomatis via `init.sql`) selesai sepenuhnya.

## Langkah Menguji Aplikasi
1. Buka browser dan akses UI Kasir di: `http://localhost:8080`
2. Uji coba menambahkan data pesanan baru menggunakan formulir yang tersedia. Data akan otomatis masuk ke MySQL persisten.
3. Untuk menguji output API, klik tombol "Cek Output API (JSON)" atau akses: `http://localhost:8080/?api=true`
4. Untuk memverifikasi *health check* dan status jaringan antarlayanan, jalankan perintah di terminal: `docker-compose ps` (pastikan layanan db berstatus *healthy*).