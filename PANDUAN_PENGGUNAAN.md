# GIS Hospital Surabaya - Panduan Penggunaan

## 🚀 Fitur Aplikasi

### ✅ 1. Tampilan Peta OpenStreetMap
- Peta interaktif menggunakan Leaflet.js
- Marker untuk setiap fasilitas kesehatan
- Popup info detail saat klik marker

### ✅ 2. CRUD Objek Point
**Cara Tambah Data:**
1. Klik tombol **"Aktifkan Mode Tambah"** di sidebar kanan
2. Klik di peta pada lokasi yang diinginkan
3. Form akan muncul dengan koordinat otomatis terisi
4. Isi data: Nama, Kategori, Kecamatan, Alamat, Telepon, Deskripsi
5. Klik **"Simpan"**

**Edit & Hapus:**
- Klik marker pada peta
- Di popup, klik tombol **"Edit"** untuk edit atau **"Hapus"** untuk hapus

### ✅ 3. Search Non-Spasial (Berbasis Atribut)

#### A. Cari Berdasarkan Nama
1. Ketik nama fasilitas di kolom "Cari berdasarkan nama..."
2. Klik tombol **"Cari"**
3. Hasil akan ditampilkan di peta

**Contoh:**
- Ketik: "Soetomo"
- Hasil: RSU Dr. Soetomo akan muncul

#### B. Filter Berdasarkan Kategori
1. Pilih kategori dari dropdown (Rumah Sakit, Puskesmas, Klinik, Apotek, Lab Kesehatan)
2. Klik tombol **"Cari"**
3. Hanya marker dengan kategori tersebut yang tampil

**Contoh:**
- Pilih: "Rumah Sakit"
- Hasil: 3 Rumah Sakit (Dr. Soetomo, UNAIR, Premier)

#### C. Filter Berdasarkan Kecamatan
1. Pilih kecamatan dari dropdown (31 kecamatan Surabaya)
2. Klik tombol **"Cari"**
3. Hanya marker di kecamatan tersebut yang tampil

**Contoh:**
- Pilih: "Gubeng"
- Hasil: Fasilitas di Kecamatan Gubeng

#### D. Kombinasi Filter
Anda bisa kombinasikan nama + kategori + kecamatan sekaligus!

**Contoh:**
- Nama: "Apotek"
- Kategori: "Apotek"
- Kecamatan: "Gubeng"
- Hasil: Apotek K24 Gubeng

### ✅ 4. Search Spasial (Pencarian Berdasarkan Radius)

**Menggunakan Haversine Formula di SQL Server**

#### Cara Pakai:
1. **Klik di peta** untuk menentukan titik pusat pencarian
   - Marker merah akan muncul sebagai titik pusat
2. Set **radius** dalam kilometer (default 5 km, max 50 km)
3. Klik tombol **"Cari dalam Radius"**
4. Lingkaran biru akan muncul menunjukkan area pencarian
5. Semua fasilitas dalam radius tersebut akan ditampilkan
6. Jarak setiap fasilitas dari titik pusat akan ditampilkan

**Contoh Penggunaan:**

**Skenario 1: Cari Rumah Sakit Terdekat**
- Klik di peta sekitar ITS (koordinat: -7.2820, 112.7950)
- Set radius: 5 km
- Klik "Cari dalam Radius"
- Hasil: RS UNAIR (3.2 km), RSU Dr. Soetomo (3.8 km)

**Skenario 2: Cari Apotek dalam 2 km**
- Klik di Gubeng area
- Set radius: 2 km
- Hasil: Apotek dalam 2 km dari titik yang diklik

**Skenario 3: Cari Semua Fasilitas Kesehatan dalam 10 km**
- Klik di pusat Surabaya (-7.2575, 112.7521)
- Set radius: 10 km
- Hasil: Semua 13 fasilitas kesehatan terdekat dengan info jarak

### ✅ 5. Reset Tampilan
Klik tombol **"Reset Tampilan"** untuk:
- Hapus semua filter
- Tampilkan semua marker
- Kembali ke view awal (Surabaya center)

---

## 📊 Data Yang Tersedia

### Kategori (5):
1. Rumah Sakit
2. Puskesmas
3. Klinik
4. Apotek
5. Lab Kesehatan

### Kecamatan (31):
Semua kecamatan di Surabaya (Asemrowo, Benowo, Bubutan, Bulak, dll.)

### Data Contoh (13 fasilitas):
- **3 Rumah Sakit**: Dr. Soetomo, UNAIR, Premier
- **3 Puskesmas**: Gubeng, Mulyorejo, Sukolilo
- **2 Klinik**: Galaxy, Sejahtera Medika
- **3 Apotek**: K24, Kimia Farma, Century
- *+ 2 data yang Anda tambahkan sendiri*

---

## 🧪 Testing Fitur Search

### Test 1: Search Non-Spasial
```
1. Search Nama: "Soetomo"
   Expected: 1 hasil (RSU Dr. Soetomo)

2. Filter Kategori: "Puskesmas"
   Expected: 3 hasil (Gubeng, Mulyorejo, Sukolilo)

3. Filter Kecamatan: "Gubeng"
   Expected: 4 hasil (RS Soetomo, Puskesmas Gubeng, Klinik Galaxy, Apotek K24)

4. Kombinasi - Kategori: "Apotek", Kecamatan: "Gubeng"
   Expected: 1 hasil (Apotek K24 Gubeng)
```

### Test 2: Search Spasial (Radius)
```
Koordinat Test: -7.2656, 112.7520 (RS Soetomo)

1. Radius 1 km:
   Expected: 3-4 fasilitas terdekat

2. Radius 5 km:
   Expected: 7-9 fasilitas

3. Radius 10 km:
   Expected: Semua 13 fasilitas
```

---

## 🔧 Teknologi Yang Digunakan

### Backend:
- **Laravel 11** - PHP Framework
- **SQL Server Express** - Database
- **Eloquent ORM** - Database queries
- **Haversine Formula** - Perhitungan jarak geografis

### Frontend:
- **Leaflet.js** - OpenStreetMap integration
- **Bootstrap 5** - UI Framework
- **jQuery** - AJAX calls
- **SweetAlert2** - Notifications

### Formula Haversine (SQL Server):
```sql
(6371 * 2 * ASIN(SQRT(
    POWER(SIN((RADIANS(lat1) - RADIANS(lat2)) / 2), 2) +
    COS(RADIANS(lat1)) * COS(RADIANS(lat2)) *
    POWER(SIN((RADIANS(lng1) - RADIANS(lng2)) / 2), 2)
)))
```
*Hasilnya dalam kilometer*

---

## 📝 API Endpoints

### Points API:
- `GET /api/points` - Get all points (GeoJSON)
- `GET /api/objek-point` - Get all points (JSON)
- `POST /api/objek-point` - Create new point
- `GET /api/objek-point/{id}` - Get single point
- `PUT /api/objek-point/{id}` - Update point
- `DELETE /api/objek-point/{id}` - Delete point

### Search API:
- `GET /api/search/attribute?nama=...&kategori_id=...&kecamatan_id=...`
  - Search by name, category, or district
  
- `GET /api/search/radius?latitude=...&longitude=...&radius=...`
  - Search by radius using Haversine formula
  
- `GET /api/search/nearest?latitude=...&longitude=...&limit=10`
  - Get nearest points from coordinate

### Lines & Polygons:
- `GET /api/lines` - Get all lines (roads)
- `GET /api/polygons` - Get all polygons (areas)

---

## 🎯 Memenuhi Spesifikasi Tugas

### ✅ A. Search Non-Spasial (Wajib)
- [x] Cari berdasarkan nama objek
- [x] Filter berdasarkan kategori
- [x] Filter berdasarkan kecamatan
- [x] Hasil tampil sebagai marker terfilter

### ✅ B. Search Spasial (Wajib - pilih salah satu)
- [x] **Pencarian Berdasarkan Radius (Buffer Search)**
  - Tampilkan fasilitas dalam radius X km dari titik yang diklik
  - Menggunakan **Haversine Formula di SQL Server**
  - Menampilkan lingkaran radius di peta
  - Menampilkan jarak dari titik pusat

### ✅ Layer GIS Minimal 3:
1. [x] **Layer Point** - Lokasi fasilitas kesehatan
2. [x] **Layer Line** - Jalan/rute (struktur ready, bisa ditambah data)
3. [x] **Layer Polygon** - Area/kecamatan (struktur ready, bisa ditambah data)

### ✅ CRUD Minimal Point Layer:
- [x] Create - Tambah objek via klik peta
- [x] Read - Tampilkan semua objek
- [x] Update - Edit objek
- [x] Delete - Hapus objek

---

## 🚀 Cara Menjalankan

1. **Start Laravel Server:**
   ```bash
   php artisan serve
   ```
   Akses: http://localhost:8000

2. **Start Vite Dev Server:**
   ```bash
   npm run dev
   ```

3. Buka browser dan mulai testing!

---

## 📦 Export Database SQL

Untuk mengekspor database ke file SQL untuk dikumpulkan:

```bash
sqlcmd -S localhost\SQLEXPRESS -d gis_hospital_surabaya -E -o database_export.sql -Q "SELECT * FROM kategori; SELECT * FROM kecamatan; SELECT * FROM objek_point;"
```

Atau gunakan SQL Server Management Studio (SSMS):
1. Klik kanan database `gis_hospital_surabaya`
2. Tasks → Generate Scripts
3. Pilih semua tables
4. Save to file

---

## 🎓 Dibuat Untuk Tugas
**Mata Kuliah:** Teknologi Basis Data (GIS Database + OpenStreetMap)  
**Fitur:** Search Non-Spasial & Spasial (Haversine Formula di SQL Server)  
**Framework:** Laravel 11 + Leaflet.js + SQL Server

---

**Selamat Mencoba! 🚀**
