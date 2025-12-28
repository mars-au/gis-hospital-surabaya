# GIS Hospital Surabaya

Aplikasi pemetaan interaktif untuk fasilitas kesehatan di Kota Surabaya dengan fitur pencarian spasial dan non-spasial. Dibangun dengan Laravel 12, Leaflet.js, Turf.js, dan SQL Server.

## Fitur Utama

### 1. Tampilan Peta Interaktif & Layering
Peta berbasis OpenStreetMap dengan Leaflet.js yang dilengkapi **Layer Control** untuk mengatur visibilitas:
- **Base Maps**: OpenStreetMap, CartoDB Light, CartoDB Dark, Satellite.
- **Overlay Layers**: 
  - **Fasilitas Kesehatan** (Point markers).
  - **Jalan Utama** (Line features) - Tampilan jaringan jalan.
  - **Area Kecamatan** (Polygon features) - Batas wilayah administratif.

### 2. Pencarian Non-Spasial (Attribute-based)
Pencarian fleksibel dengan kombinasi filter:
- **Nama Fasilitas**: Pencarian teks real-time.
- **Kategori**: Filter 5 kategori (Rumah Sakit, Puskesmas, Klinik, Apotek, Lab Kesehatan).
- **Kecamatan**: Filter lokasi administratif.
- **Visualisasi Area (Convex Hull)**: Saat memfilter per kecamatan, sistem otomatis menggambarkan area cakupan fasilitas menggunakan algorithm Convex Hull dari **Turf.js**.

### 3. Pencarian Spasial (Radius/Buffer Search)
Analisis spasial interaktif:
- Klik peta untuk menentukan titik pusat (center point).
- Atur radius pencarian (0.1 - 20 km).
- Visualisasi lingkaran radius pada peta.
- Menampilkan daftar fasilitas dalam radius beserta **perhitungan jarak geospasial real-time**.

### 4. Manajemen Data (CRUD)
- **Create**: Tambah lokasi baru interaktif (klik peta untuk ambil koordinat).
- **Read**: Detail lengkap fasilitas (alamat, telepon, deskripsi) via popup.
- **Update**: Edit data fasilitas secara langsung.
- **Delete**: Hapus data fasilitas.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | Laravel 12, PHP 8.2+ |
| **Database** | SQL Server (SQLEXPRESS) |
| **Frontend** | Leaflet.js 1.9.4, Turf.js (Geospatial Analysis) |
| **Styling** | CSS3, Bootstrap 5, Font Awesome 6 |
| **API** | RESTful API (GeoJSON Standard) |

---

## Database Structure

**Tabel Utama:**
- `objek_points`: Data fasilitas kesehatan (Latitude, Longitude).
- `jalans`: Data jaringan jalan (LineString GeoJSON).
- `areas`: Data batas wilayah/polygon (Polygon GeoJSON).
- `kategoris`: Klasifikasi fasilitas.
- `kecamatans`: Data referensi wilayah.

**Default Data Seeds:**
- **Fasilitas**: RS Dr. Soetomo, RS UNAIR, Puskesmas Mulyorejo, dll.
- **Jalan**: Jalan Raya Darmo, Jalan Basuki Rahmat, MERR.
- **Area**: Polygon wilayah Gubeng, Mulyorejo, Sukolilo.

---

## API Endpoints

Semua endpoint mengembalikan format standar **GeoJSON**.

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/points` | Semua data fasilitas kesehatan (Points) |
| GET | `/api/lines` | Data jaringan jalan (Lines) |
| GET | `/api/polygons` | Data area kecamatan (Polygons) |
| GET | `/api/polygon-by-kecamatan` | Polygon spesifik berdasarkan ID kecamatan |
| POST | `/api/objek-point` | Tambah data point baru |
| PUT | `/api/objek-point/{id}` | Update data point |
| DELETE | `/api/objek-point/{id}` | Hapus data point |
| GET | `/api/search/attribute` | Cari berdasarkan nama, kategori, kecamatan |
| GET | `/api/search/radius` | Cari fasilitas dalam radius tertentu |
| GET | `/api/search/nearest` | Cari fasilitas terdekat (Nearest Neighbor) |

---

## Project Structure

```
gis-hospital-surabaya/
├── app/
│   ├── Http/Controllers/
│   │   ├── MapController.php        # GeoJSON APIs & View Logic
│   │   ├── ObjekPointController.php # CRUD Operations
│   │   └── SearchController.php     # Spatial & Attribute Search
│   └── Models/
│       ├── ObjekPoint.php           # Point Data
│       ├── Jalan.php                # Line Data
│       └── Area.php                 # Polygon Data
├── database/
│   ├── migrations/                  # Schema Definitions
│   └── seeders/                     # Spatial Data Seeders
├── resources/views/map/
│   └── index.blade.php              # Main Interface (Map, Leaflet, Turf.js)
└── routes/
    └── web.php                      # Application Routes
```

---

## Installation & Setup

1. **Clone & Install Dependencies**
   ```bash
   git clone [repo-url]
   cd gis-hospital-surabaya
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Configuration** (.env)
   ```env
   DB_CONNECTION=sqlsrv
   DB_HOST=localhost\SQLEXPRESS
   DB_DATABASE=gis_hospital_surabaya
   DB_USERNAME=sa
   DB_PASSWORD=your_password
   ```

4. **Migrate & Seed Data**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   *Note: Seeding includes spatial data for demo purposes.*

5. **Run Application**
   ```bash
   npm run build
   php artisan serve
   ```
   Buka di browser: `http://localhost:8000`

---

## Testing Scenarios

1. **Toggle Layers**: Coba nyalakan/matikan layer "Jalan Utama" dan "Area Kecamatan" di pojok kanan atas peta.
2. **Convex Hull**: Pilih filter "Kecamatan: Gubeng", lihat area polygon ungu yang otomatis terbentuk melingkupi fasilitas yang ada.
3. **Radius Search**: Klik peta di area Sukolilo, set radius 3 KM, pastikan RS UNAIR dan ITS Medical Center terdeteksi.
4. **CRUD**: Coba tambahkan titik baru, kemudian refresh halaman untuk memastikan data tersimpan persisten.
