# Dokumentasi Optimasi Kode Fintech App

## Ringkasan Perubahan

Dokumen ini menjelaskan optimasi kode yang telah dilakukan pada proyek Fintech App untuk meningkatkan efisiensi, struktur, dan maintainability kode tanpa mengubah fitur yang ada.

---

## 1. Penambahan Service Layer

### Lokasi: `app/Services/`

Service layer ditambahkan untuk memisahkan business logic dari controller, menjadikan kode lebih testable dan reusable.

#### WalletService (`app/Services/WalletService.php`)

- `createWallet()` - Membuat wallet baru untuk user
- `addBalance()` - Menambah saldo wallet
- `deductBalance()` - Mengurangi saldo wallet
- `hasSufficientBalance()` - Cek apakah saldo mencukupi
- `findByRekening()` - Cari wallet berdasarkan nomor rekening
- `findByUserId()` - Cari wallet berdasarkan user ID

#### TransaksiService (`app/Services/TransaksiService.php`)

- `processCheckout()` - Proses checkout dengan database transaction
- `confirmTransaction()` - Konfirmasi transaksi
- `rejectTransaction()` - Tolak transaksi dan kembalikan stok/saldo
- `cancelTransaction()` - Batalkan transaksi oleh siswa
- `getBestSeller()` - Dapatkan produk best seller
- `getDailyReport()` - Dapatkan laporan harian

#### BankingService (`app/Services/BankingService.php`)

- `processTopup()` - Proses request top up
- `confirmTopup()` / `rejectTopup()` - Konfirmasi/tolak top up
- `processWithdrawal()` - Proses request withdrawal
- `confirmWithdrawal()` / `rejectWithdrawal()` - Konfirmasi/tolak withdrawal
- `getTopupReport()` / `getWithdrawalReport()` - Laporan harian

---

## 2. Penambahan Traits

### Lokasi: `app/Traits/`

#### GeneratesUniqueCode (`app/Traits/GeneratesUniqueCode.php`)

Trait untuk generate kode unik yang sebelumnya tersebar di berbagai controller:

- `generateInvoiceNumber()` - Generate nomor invoice
- `generateTopupCode()` - Generate kode top up
- `generateWithdrawalCode()` - Generate kode withdrawal
- `generateAccountNumber()` - Generate nomor rekening

---

## 3. Optimasi Form Requests

### Lokasi: `app/Http/Requests/`

Form Request yang sebelumnya kosong sekarang berisi validasi yang tepat:

| File                        | Deskripsi                          |
| --------------------------- | ---------------------------------- |
| `StoreProdukRequest.php`    | Validasi untuk membuat produk baru |
| `UpdateProdukRequest.php`   | Validasi untuk update produk       |
| `StoreKategoriRequest.php`  | Validasi untuk membuat kategori    |
| `UpdateKategoriRequest.php` | Validasi untuk update kategori     |
| `LoginRequest.php`          | Validasi login (baru)              |
| `RegisterRequest.php`       | Validasi registrasi (baru)         |
| `TopupRequest.php`          | Validasi top up (baru)             |
| `WithdrawalRequest.php`     | Validasi withdrawal (baru)         |
| `AddToCartRequest.php`      | Validasi add to cart (baru)        |

**Dihapus:**

- `StoreWalletRequest.php` (tidak terpakai)
- `UpdateWalletRequest.php` (tidak terpakai)

---

## 4. Optimasi Controllers

### Perubahan Umum:

- Menggunakan Service Layer untuk business logic
- Menggunakan Form Request untuk validasi
- Menghapus method kosong yang tidak terpakai (create, show, edit)
- Menggunakan array syntax untuk view data (menggantikan compact)
- Konsistensi penggunaan `auth()->id()` vs `auth()->user()->id`

### Perbaikan Bug:

- **BankController::cetakSeluruhWithdrawal()** - Sebelumnya salah menggunakan `TopUp` model, sekarang benar menggunakan `Withdrawal`
- **ProdukController::destroy()** - Sebelumnya salah mereferensi `$produk->image`, sekarang benar `$produk->foto`
- **UserController::update()** - Validasi yang rusak diperbaiki

---

## 5. Optimasi Models

### Perubahan Umum:

- Menggunakan `$fillable` eksplisit (bukan `$guarded`)
- Menambahkan `$casts` untuk type casting
- Menambahkan return types pada relasi
- Menambahkan helper methods dan scopes
- Menambahkan status constants

### User.php

- Menambahkan `isAdmin()`, `isSiswa()`, `isBank()`, `isKantin()` helpers
- Menambahkan relasi `wallet()` (hasOne)

### Produk.php

- Menambahkan `getFotoUrlAttribute()` accessor
- Menambahkan `scopeAvailable()` dan `isAvailable()`
- Menambahkan relasi `keranjangs()`

### Transaksi.php

- Menambahkan status constants
- Menambahkan `scopePending()`, `scopeConfirmed()`, `scopeActive()`
- Menambahkan `isConfirmed()`, `isPending()`

### Wallet.php

- Menambahkan relasi `topups()` dan `withdrawals()`
- Menambahkan `isActive()`, `hasSufficientBalance()`
- Menambahkan `getFormattedSaldoAttribute()`

### TopUp.php & Withdrawal.php

- Menambahkan status constants
- Menambahkan scopes dan helper methods
- Menambahkan `getFormattedNominalAttribute()`

---

## 6. Optimasi Routes

### Perubahan:

- Mengelompokkan routes dengan komentar yang jelas
- Struktur route names dipertahankan untuk backward compatibility
- Menggunakan `only()` pada resource routes untuk menghapus method yang tidak terpakai

---

## 7. Query Optimization

### Perubahan:

- Menggunakan eager loading dengan `with()` untuk menghindari N+1 query
- Menggunakan `increment()` dan `decrement()` untuk update counter
- Menggunakan mass update dengan `where()->update()` bukan loop
- Menggunakan Database Transaction untuk operasi kritis

---

## Struktur Folder Baru

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php (optimized)
│   │   ├── BankController.php (optimized)
│   │   ├── DashboardController.php (optimized)
│   │   ├── KategoriController.php (optimized)
│   │   ├── ProdukController.php (optimized)
│   │   ├── TransaksiController.php (optimized)
│   │   └── UserController.php (optimized)
│   └── Requests/
│       ├── AddToCartRequest.php (new)
│       ├── LoginRequest.php (new)
│       ├── RegisterRequest.php (new)
│       ├── StoreKategoriRequest.php (filled)
│       ├── StoreProdukRequest.php (filled)
│       ├── TopupRequest.php (new)
│       ├── UpdateKategoriRequest.php (filled)
│       ├── UpdateProdukRequest.php (filled)
│       └── WithdrawalRequest.php (new)
├── Models/ (all optimized)
├── Services/ (new)
│   ├── BankingService.php
│   ├── TransaksiService.php
│   └── WalletService.php
└── Traits/ (new)
    └── GeneratesUniqueCode.php
```

---

## Catatan Penting

1. **Tidak ada perubahan database** - Struktur database tetap sama
2. **Tidak ada perubahan views** - Semua view files tetap kompatibel
3. **Route names dipertahankan** - Semua nama route yang digunakan di views tetap sama
4. **Fungsionalitas tetap** - Semua fitur berfungsi seperti sebelumnya

---

## Testing

Setelah optimasi, pastikan untuk menguji:

1. Login dan registrasi
2. CRUD produk dan kategori
3. Transaksi (add to cart, checkout, confirm, cancel)
4. Top up dan withdrawal
5. Laporan dan cetak invoice
6. Dashboard semua role (admin, siswa, bank, kantin)
