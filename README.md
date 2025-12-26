# GIS Hospital Surabaya

Aplikasi pemetaan interaktif untuk fasilitas kesehatan di Kota Surabaya dengan fitur pencarian spasial dan non-spasial. Dibangun dengan Laravel 11, Leaflet.js, dan SQL Server.

## Fitur Utama

### Tampilan Peta Interaktif
Peta berbasis OpenStreetMap dengan Leaflet.js menggunakan **light theme modern** (mint-biru-ungu). Setiap fasilitas kesehatan ditampilkan sebagai marker yang dapat diklik untuk melihat detail lengkap termasuk nama, alamat, telepon, kategori, dan kecamatan.

### Pencarian Non-Spasial (Attribute-based)
Tiga cara mencari sekaligus bisa dikombinasikan:
- **Nama Fasilitas** - Search text real-time atau full match
- **Kategori** - Filter dari 5 kategori (Rumah Sakit, Puskesmas, Klinik, Apotek, Lab Kesehatan)
- **Kecamatan** - Pilih dari 31 kecamatan di Surabaya

### Pencarian Spasial (Radius/Buffer Search)
Klik lokasi di peta untuk titik pusat, atur radius (0.1-20 km), sistem menampilkan:
- Lingkaran radius visualisasi di peta
- Semua fasilitas dalam radius
- Jarak akurat dari titik pusat ke setiap fasilitas (Haversine Formula)

### CRUD Lengkap untuk Point Layer
- **Create** - Tambah lokasi baru dengan klik peta, auto-fill koordinat
- **Read** - Tampilkan semua fasilitas dengan detail
- **Update** - Edit data fasilitas yang sudah ada
- **Delete** - Hapus fasilitas dari database

### Dashboard Stats
Real-time statistics di sidebar menampilkan total fasilitas, jumlah kecamatan, dan kategori.

---

## Database Structure

**5 Kategori:**
Rumah Sakit, Puskesmas, Klinik, Apotek, Lab Kesehatan

**31 Kecamatan:**
Seluruh kecamatan Surabaya dari Asemrowo hingga Wonokromo

**Default Data:**
- 3 Rumah Sakit (Dr. Soetomo, UNAIR, Premier)
- 3 Puskesmas (Gubeng, Mulyorejo, Sukolilo)
- 2 Klinik (Galaxy, Sejahtera Medika)
- 3 Apotek (K24, Kimia Farma, Century)

**Models:**
- ObjekPoint - Point features
- Jalan - Line features (ready for road/route data)
- Area - Polygon features (ready for area/boundary data)

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11, PHP 8.2+ |
| Database | SQL Server Express |
| Frontend | Leaflet.js 1.9.4, Vanilla JS |
| Styling | CSS3, Bootstrap 5, Font Awesome 6 |
| Geographic | Haversine Formula (SQL Server) |

---

## API Endpoints

| Method | Endpoint | Response |
|--------|----------|----------|
| GET | / | Tampilkan peta |
| GET | /api/points | Semua points (GeoJSON) |
| POST | /api/objek-point | Create point |
| GET | /api/objek-point/{id} | Get point detail |
| PUT | /api/objek-point/{id} | Update point |
| DELETE | /api/objek-point/{id} | Delete point |
| GET | /api/search/attribute | Filter by attributes |
| GET | /api/search/radius | Search by radius |
| GET | /api/search/nearest | Get nearest points |

---

## Installation & Setup

**System Requirements:**
- PHP 8.2 atau lebih baru
- Composer
- Node.js & npm
- SQL Server Express atau SQL Server 2019+
- Laravel 11 framework

**Steps:**
```bash
# Masuk ke folder project
cd c:\laragon\www\gis-hospital-surabaya

# Install PHP & JS dependencies
composer install && npm install

# Setup environment file
cp .env.example .env
php artisan key:generate

# Configure database di .env
DB_CONNECTION=sqlsrv
DB_HOST=localhost\SQLEXPRESS
DB_DATABASE=gis_hospital_surabaya
DB_USERNAME=sa
DB_PASSWORD=your_password

# Initialize database
php artisan migrate
php artisan db:seed

# Run development server
php artisan serve
# Akses di browser: http://localhost:8000
```

---

## Design & UI

**Theme:** Light mode dengan accent colors:
- Mint Green (#00d2b5) - Primary accent
- Purple (#7e57c2) - Secondary accent  
- Blue (#42a5f5) - Tertiary accent
- White background dengan subtle gradient

**Components:**
- Responsive sidebar (380px) dengan form sections
- Full-height map dengan Leaflet controls
- Interactive markers dengan popups detail
- Alert messages untuk user feedback
- Button variants: primary, success, warning, secondary
- Icons dari Font Awesome 6

---

## Testing

**Manual Testing Checklist:**
- [ ] Open http://localhost:8000, peta load dengan semua fasilitas
- [ ] Klik marker, popup muncul dengan detail benar
- [ ] Search nama, hasil filter marker sesuai
- [ ] Filter kategori, hanya kategori terpilih tampil
- [ ] Filter kecamatan, hanya kecamatan terpilih tampil
- [ ] Kombinasi filter, semua kombinasi bekerja
- [ ] Radius search, klik peta, lingkaran muncul, hasil benar
- [ ] Tambah fasilitas, form muncul, bisa disimpan
- [ ] Edit fasilitas, data terupdate di peta
- [ ] Hapus fasilitas, marker hilang dari peta

**API Testing:**
```bash
curl http://localhost:8000/api/points
curl "http://localhost:8000/api/search/attribute?nama=Soetomo"
curl "http://localhost:8000/api/search/radius?latitude=-7.2656&longitude=112.7520&radius=5"
```

---

## Project Structure

```
gis-hospital-surabaya/
├── app/Http/Controllers/
│   ├── MapController.php           # Map & layer logic
│   ├── ObjekPointController.php    # CRUD points
│   └── SearchController.php        # Search logic
├── app/Models/
│   ├── ObjekPoint.php
│   ├── Kategori.php
│   ├── Kecamatan.php
│   ├── Jalan.php
│   └── Area.php
├── database/
│   ├── migrations/                 # 5 table schemas
│   └── seeders/                    # Default data
├── resources/views/
│   ├── layouts/app.blade.php       # Main layout & CSS
│   └── map/index.blade.php         # Map view & forms
├── routes/
│   └── web.php                     # All routes (web + API)
└── public/
    └── index.php                   # Entry point
```

---
