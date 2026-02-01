# 🏦 Fintech App - E-Wallet Kantin Sekolah

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

**Aplikasi E-Wallet untuk sistem pembayaran digital kantin sekolah**

[Instalasi](#-instalasi) • [Fitur](#-fitur) • [Penggunaan](#-penggunaan) • [Lisensi](#-lisensi)

</div>

---

## 📖 Tentang Aplikasi

**Fintech App** adalah aplikasi e-wallet berbasis web yang dirancang khusus untuk sistem pembayaran digital di lingkungan kantin sekolah. Aplikasi ini memungkinkan siswa melakukan transaksi tanpa uang tunai, dengan fitur top up saldo, pembelian produk kantin, dan penarikan tunai.

### Mengapa Fintech App?

- 💳 **Cashless** - Transaksi tanpa uang tunai untuk keamanan dan kenyamanan
- 📊 **Laporan Real-time** - Monitoring transaksi dan keuangan secara langsung
- 🔐 **Multi-Role** - Sistem dengan 4 level akses pengguna
- 📱 **Responsive** - Dapat diakses dari berbagai perangkat

---

## ✨ Fitur

### 👨‍🎓 Siswa

- ✅ Dashboard dengan informasi saldo dan riwayat transaksi
- ✅ Lihat produk kantin dan best seller
- ✅ Keranjang belanja dan checkout
- ✅ Top up saldo
- ✅ Tarik tunai (withdrawal)
- ✅ Riwayat transaksi, top up, dan withdrawal
- ✅ Cetak invoice/bukti transaksi

### 🍔 Kantin

- ✅ Dashboard dengan total pemasukan dan statistik
- ✅ Manajemen produk (CRUD)
- ✅ Manajemen kategori produk
- ✅ Konfirmasi/tolak pesanan siswa
- ✅ Laporan transaksi harian

### 🏛️ Bank

- ✅ Dashboard dengan ringkasan aktivitas
- ✅ Konfirmasi/tolak permintaan top up
- ✅ Konfirmasi/tolak permintaan withdrawal
- ✅ Laporan top up dan withdrawal
- ✅ Cetak laporan keuangan

### 👑 Admin

- ✅ Dashboard dengan statistik pengguna
- ✅ Manajemen pengguna (CRUD)
- ✅ Pengaturan role pengguna

---

## 🚀 Instalasi

### Prasyarat

Pastikan sistem Anda memiliki:

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM atau Yarn

### Langkah Instalasi

1. **Clone repository**

    ```bash
    git clone https://github.com/username/fintech-app.git
    cd fintech-app
    ```

2. **Install dependencies PHP**

    ```bash
    composer install
    ```

3. **Install dependencies JavaScript**

    ```bash
    npm install
    ```

4. **Salin file environment**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Konfigurasi database**

    Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=fintech_app
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. **Jalankan migrasi dan seeder**

    ```bash
    php artisan migrate --seed
    ```

8. **Link storage**

    ```bash
    php artisan storage:link
    ```

9. **Jalankan server**

    ```bash
    php artisan serve
    ```

10. **Akses aplikasi**

    Buka browser dan akses: `http://localhost:8000`

---

## 📁 Struktur Proyek

```
fintech-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller aplikasi
│   │   ├── Middleware/        # Middleware custom
│   │   └── Requests/          # Form Request validation
│   ├── Models/                # Eloquent models
│   ├── Services/              # Business logic services (NEW)
│   │   ├── WalletService.php
│   │   ├── TransaksiService.php
│   │   └── BankingService.php
│   └── Traits/                # Reusable traits (NEW)
│       └── GeneratesUniqueCode.php
├── config/                    # Konfigurasi aplikasi
├── database/
│   ├── factories/             # Model factories
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/                    # Public assets
├── resources/
│   ├── css/                   # Stylesheet
│   ├── js/                    # JavaScript
│   └── views/                 # Blade templates
├── routes/                    # Route definitions
├── storage/                   # File storage
└── tests/                     # Test files
```

---

## 👥 User Roles

| Role   | Deskripsi            | Akses                         |
| ------ | -------------------- | ----------------------------- |
| Admin  | Administrator sistem | Manajemen pengguna            |
| Siswa  | Pengguna utama       | Transaksi, top up, withdrawal |
| Kantin | Penjual              | Produk, pesanan, laporan      |
| Bank   | Petugas keuangan     | Top up, withdrawal, laporan   |

---

## 🔧 Penggunaan

### Sebagai Siswa

1. **Login** dengan akun siswa
2. **Lihat saldo** di dashboard
3. **Top up saldo** melalui menu top up (menunggu konfirmasi bank)
4. **Belanja** di menu Kantin
5. **Tambah ke keranjang** produk yang diinginkan
6. **Checkout** untuk menyelesaikan transaksi
7. **Lihat riwayat** transaksi di menu Riwayat

### Sebagai Kantin

1. **Login** dengan akun kantin
2. **Kelola produk** melalui menu Produk (tambah, edit, hapus)
3. **Kelola kategori** melalui menu Kategori
4. **Konfirmasi pesanan** yang masuk dari siswa
5. **Lihat laporan** transaksi harian

### Sebagai Bank

1. **Login** dengan akun bank
2. **Konfirmasi top up** dari siswa
3. **Konfirmasi withdrawal** dari siswa
4. **Lihat laporan** keuangan

### Sebagai Admin

1. **Login** dengan akun admin
2. **Kelola pengguna** (tambah, edit, hapus, ubah role)

---

## 🏗️ Arsitektur Kode

### Service Layer Pattern

Aplikasi ini menggunakan **Service Layer Pattern** untuk memisahkan business logic dari controller:

- **WalletService** - Manajemen wallet (create, add/deduct balance)
- **TransaksiService** - Proses checkout, konfirmasi, tolak transaksi
- **BankingService** - Proses top up dan withdrawal

### Form Requests

Validasi input menggunakan **Form Request** untuk kode yang lebih bersih:

- `LoginRequest`, `RegisterRequest`
- `StoreProdukRequest`, `UpdateProdukRequest`
- `StoreKategoriRequest`, `UpdateKategoriRequest`
- `TopupRequest`, `WithdrawalRequest`, `AddToCartRequest`

### Traits

- **GeneratesUniqueCode** - Generate invoice, kode top up/withdrawal, nomor rekening

---

## 🛠️ Development

### Commands Berguna

```bash
# Jalankan development server
php artisan serve

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Jalankan tests
php artisan test

# Code formatting
./vendor/bin/pint
```

---

## 🔒 Keamanan

- Password di-hash menggunakan bcrypt
- Validasi input dengan Form Request
- Middleware untuk kontrol akses berdasarkan role
- Database transaction untuk operasi kritis

---

## 📝 Catatan PHP 8.4+

Jika Anda menggunakan PHP 8.4+, beberapa deprecation warning dari dependencies mungkin muncul. Aplikasi ini sudah dikonfigurasi untuk menyembunyikan warning tersebut. Untuk mengembalikan tampilan warning, edit `bootstrap/app.php` dan hapus baris:

```php
error_reporting(E_ALL & ~E_DEPRECATED);
```

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 👨‍💻 Author

Dikembangkan dengan ❤️ untuk kemudahan transaksi di kantin sekolah.

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [AdminLTE](https://adminlte.io) - Admin Dashboard Template
- [Font Awesome](https://fontawesome.com) - Icons
- [SweetAlert2](https://sweetalert2.github.io) - Beautiful Alerts
