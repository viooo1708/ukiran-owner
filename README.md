# Ukiran Owner Application

Aplikasi berbasis Laravel untuk manajemen dan administrasi bisnis ukiran/kerajinan (`ukiran-owner`).

---

## Cara Menjalankan Website (Running Instructions)

Untuk menjalankan website secara lokal menggunakan port `1001`, ikuti langkah-langkah berikut di terminal pada direktori proyek (`ukiran-owner` atau root proyek):

1. **Install Dependencies PHP (Composer):**
   ```bash
   composer install
   ```

2. **Install Dependencies Node.js & Build Asset Frontend:**
   ```bash
   npm install
   npm run build
   ```

3. **Konfigurasi File Environment:**
   Salin file `.env.example` menjadi `.env` dan generate application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database:**
   Jalankan migrasi database (misalnya SQLite / MySQL yang dikonfigurasi di `.env`):
   ```bash
   php artisan migrate
   ```

5. **Jalankan Server Laravel pada Port 1001:**
   ```bash
   php artisan serve --port=1001
   ```

6. **Akses Website:**
   Buka browser dan akses URL: `http://127.0.0.1:1001`

---

## Fitur dan Fungsi Aplikasi

Berdasarkan struktur kode dan kontroler yang ada pada proyek ini, berikut adalah fitur-fitur utama beserta fungsinya:

1. **Autentikasi (`AuthController`)**
   - **Fungsi:** Mengelola proses *login*, *register*, autentikasi pengguna, serta manajemen sesi akun.

2. **Dashboard (`DashboardController`)**
   - **Fungsi:** Menyediakan halaman utama panel admin yang menampilkan ringkasan data, statistik, dan metrik penting bisnis ukiran.

3. **Manajemen Pesanan (`OrderController`)**
   - **Fungsi:** Mengelola pesanan masuk dari pelanggan, memantau status pesanan, rincian produk yang dipesan, dan alur pemenuhan pesanan.

4. **Manajemen Produk (`ProductController`)**
   - **Fungsi:** Mengelola katalog produk ukiran (tambah, ubah, hapus, dan lihat detail produk, harga, serta informasi stok).

5. **Manajemen Profil & Pengguna (`ProfileController` & `UserController`)**
   - **Fungsi:** Memungkinkan pengguna atau pemilik mengelola informasi profil pribadi, mengubah kata sandi, serta administrasi data pengguna sistem.

6. **Laporan (`ReportController`)**
   - **Fungsi:** Menghasilkan laporan analitik penjualan dan operasional bisnis untuk keperluan evaluasi pemilik.

7. **Layanan API (`ApiService`)**
   - **Fungsi:** Menangani komunikasi data berbasis API internal maupun eksternal.

8. **Hak Akses Pemilik (`OwnerMiddleware`)**
   - **Fungsi:** Berperan sebagai pengaman rute (*middleware*) untuk memastikan hanya pengguna dengan hak akses pemilik (*owner*) yang dapat mengakses halaman atau fitur administratif tertentu.
