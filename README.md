# Sistem Informasi Penjualan - Mang Bob

Sistem Point of Sale (POS) berbasis web untuk usaha Mie Ayam Bangka Mang Bob. Dibangun menggunakan Laravel 13 dengan Bootstrap 5.

## Fitur

- **Dashboard** — Ringkasan penjualan harian, grafik 7 hari terakhir, dan transaksi terakhir (akses Owner)
- **Manajemen Menu** — CRUD menu makanan dan minuman dengan informasi harga dan stok (akses Owner)
- **Transaksi (POS)** — Antarmuka kasir untuk memilih menu, menghitung total, dan memproses pembayaran (akses Kasir)
- **Struk Digital** — Cetak struk transaksi dalam format yang siap dicetak
- **Riwayat Transaksi** — Daftar seluruh transaksi dengan detail item (akses Owner & Kasir)
- **Laporan Harian** — Generate laporan penjualan per hari dengan export PDF (akses Owner)

## Role

| Role | Akses |
|------|-------|
| **Owner** | Dashboard, Manajemen Menu, Laporan, Riwayat |
| **Kasir** | Transaksi, Riwayat |

## Teknologi

- **Backend:** Laravel 13, PHP 8.3
- **Frontend:** Bootstrap 5, Chart.js
- **Database:** SQLite
- **PDF:** DomPDF

## Instalasi

```bash
# Clone repository
git clone https://github.com/irhamrizqan/sistem-informasi-penjualan-mang-bob.git
cd sistem-informasi-penjualan-mang-bob

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database migration & seed
php artisan migrate --seed

# Jalankan server
php artisan serve
```

## Akun Default

| Email | Password | Role |
|-------|----------|------|
| mangbob@gmail.com | password | Owner |
| kasir1@gmail.com | password | Kasir |
| kasir2@gmail.com | password | Kasir |

## Struktur Projek

```
├── app/
│   ├── Http/Controllers/    # Controller aplikasi
│   ├── Models/              # Model Eloquent
│   ├── Services/            # Service layer (Transaksi, Laporan)
│   └── View/Components/     # Komponen Blade
├── database/
│   ├── migrations/          # Struktur database
│   └── seeders/             # Data awal
├── resources/views/         # Template Blade
│   ├── dashboard/           # Dashboard
│   ├── menu/                # Manajemen menu
│   ├── transaction/         # Transaksi & riwayat
│   ├── report/              # Laporan
│   └── auth/                # Autentikasi
└── routes/                  # Routing aplikasi
```

## License

MIT
