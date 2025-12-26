@extends('layouts.app')

@section('title', 'Hospital GIS Surabaya')

@section('sidebar')
<!-- -->
<!-- PENCARIAN FASILITAS -->
<!-- -->
<div class="form-section">
    <div class="section-title">
        <i class="fas fa-search"></i>
        <span>PENCARIAN FASILITAS</span>
    </div>

    <div class="form-group">
        <label><i class="fas fa-font"></i> NAMA FASILITAS</label>
        <input type="text" id="searchNama" class="form-control"
               placeholder="Masukkan nama fasilitas">
    </div>

    <div class="form-group">
        <label><i class="fas fa-tag"></i> KATEGORI</label>
        <select id="filterKategori" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label><i class="fas fa-map-marker-alt"></i> KECAMATAN</label>
        <select id="filterKecamatan" class="form-control">
            <option value="">Semua Kecamatan</option>
            @foreach($kecamatans as $kec)
                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
            @endforeach
        </select>
    </div>

    <button id="btnSearch" class="btn btn-primary w-100">
        <i class="fas fa-search"></i> Cari Fasilitas
    </button>
</div>

<!-- -->
<!-- PENCARIAN RADIUS PETA -->
<!-- -->
<div class="form-section">
    <div class="section-title">
        <i class="fas fa-crosshairs"></i>
        <span>PENCARIAN RADIUS (PETA)</span>
    </div>

    <div class="alert">
        Klik pada peta untuk menentukan titik pusat pencarian
    </div>

    <div class="form-group">
        <label><i class="fas fa-ruler"></i> RADIUS (KM)</label>
        <input type="number" id="radiusKm" class="form-control"
               value="2" min="0.1" step="0.1">
    </div>

    <button id="btnRadiusSearch" class="btn btn-success w-100" disabled>
        <i class="fas fa-bullseye"></i> Cari dalam Radius
    </button>
</div>

<button id="btnReset" class="btn btn-secondary w-100 mt-2">
    <i class="fas fa-redo"></i> Reset
</button>
@endsection

@section('content')
<div id="map"></div>
@endsection

@section('scripts')
<script>
/* 
   INIT MAP
 */
const map = L.map('map').setView([-7.2575, 112.7521], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

const pointsLayer = L.layerGroup().addTo(map);
const searchLayer = L.layerGroup().addTo(map);

let searchCenter = null;
let searchMarker = null;
let radiusCircle = null;

/* 
   LOAD DATA
 */
function loadPoints() {
    $.get('/api/points', data => {
        pointsLayer.clearLayers();
        data.features.forEach(addPoint);
    });
}

/* 
   ADD MARKER
 */
function addPoint(feature) {
    const c = feature.geometry.coordinates;
    const p = feature.properties;

    L.marker([c[1], c[0]])
        .addTo(pointsLayer)
        .bindPopup(`
            <b>${p.nama_objek}</b><br>
            ${p.kategori?.nama_kategori || ''}<br>
            ${p.kecamatan?.nama_kecamatan || ''}
        `);
}

/* 
   HANDLE RESULT
 */
function handleResult(res) {
    pointsLayer.clearLayers();
    searchLayer.clearLayers();

    if (!res.data || res.data.length === 0) {
        Swal.fire('Info', 'Tidak ada fasilitas ditemukan', 'info');
        return;
    }

    res.data.forEach(p => {
        addPoint({
            geometry: { coordinates: [p.longitude, p.latitude] },
            properties: p
        });
    });
}

/* 
   SEARCH FASILITAS
 */
$('#btnSearch').click(() => {
    $.get('/api/search/attribute', {
        nama: $('#searchNama').val(),
        kategori_id: $('#filterKategori').val(),
        kecamatan_id: $('#filterKecamatan').val()
    }, handleResult);
});

/* 
   MAP CLICK (CENTER)
 */
map.on('click', e => {
    searchCenter = e.latlng;

    if (searchMarker) map.removeLayer(searchMarker);
    searchMarker = L.marker(e.latlng)
        .addTo(map)
        .bindPopup('Titik pusat pencarian')
        .openPopup();

    $('#btnRadiusSearch').prop('disabled', false);
});

/* 
   RADIUS SEARCH
 */
$('#btnRadiusSearch').click(() => {
    $.get('/api/search/radius', {
        latitude: searchCenter.lat,
        longitude: searchCenter.lng,
        radius: $('#radiusKm').val()
    }, res => {
        if (radiusCircle) map.removeLayer(radiusCircle);

        radiusCircle = L.circle(searchCenter, {
            radius: $('#radiusKm').val() * 1000
        }).addTo(searchLayer);

        handleResult(res);
    });
});

/* 
   RESET
 */
$('#btnReset').click(() => {
    pointsLayer.clearLayers();
    searchLayer.clearLayers();

    if (searchMarker) map.removeLayer(searchMarker);
    if (radiusCircle) map.removeLayer(radiusCircle);

    searchCenter = null;
    $('#btnRadiusSearch').prop('disabled', true);

    loadPoints();
    map.setView([-7.2575, 112.7521], 13);
});

/* INIT */
loadPoints();
</script>
@endsection
