@extends('layouts.app')

@section('title', 'Hospital GIS Surabaya')

@section('sidebar')
<!-- Search Section -->
<div class="form-section">
    <div class="section-title">
        <i class="fas fa-search"></i>
        <span>PENCARIAN FASILITAS</span>
    </div>
    
    <div class="form-group">
        <label for="searchNama">
            <i class="fas fa-font"></i> NAMA FASILITAS
        </label>
        <input type="text" id="searchNama" class="form-control" placeholder="Masukkan nama fasilitas...">
    </div>
    
    <div class="form-group">
        <label for="filterKategori">
            <i class="fas fa-tag"></i> KATEGORI
        </label>
        <select id="filterKategori" class="form-control">
    <option value="" data-icon="fas fa-layer-group">
        Semua Kategori
    </option>

    @foreach($kategoris as $kategori)
        @php
            $nama = strtolower($kategori->nama_kategori);
            $icon = 'fas fa-tag';

            if (str_contains($nama, 'rumah sakit')) {
                $icon = 'fas fa-hospital-alt';
            } elseif (str_contains($nama, 'puskesmas')) {
                $icon = 'fas fa-first-aid';
            } elseif (str_contains($nama, 'klinik')) {
                $icon = 'fas fa-clinic-medical';
            } elseif (str_contains($nama, 'apotek')) {
                $icon = 'fas fa-pills';
            }
        @endphp

        <option value="{{ $kategori->id }}" data-icon="{{ $icon }}">
            {{ $kategori->nama_kategori }}
        </option>
    @endforeach
</select>

    </div>
    
    <div class="form-group">
        <label for="filterKecamatan">
            <i class="fas fa-map-marker-alt"></i> KECAMATAN
        </label>
        <select id="filterKecamatan" class="form-control">
            <option value="">Semua Kecamatan</option>
            @foreach($kecamatans as $kecamatan)
                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
            @endforeach
        </select>
    </div>
    
    <button id="btnSearch" class="btn btn-primary">
        <i class="fas fa-search"></i> Cari Fasilitas
    </button>
</div>

<!-- Radius Search Section -->
<div class="form-section">
    <div class="section-title">
        <i class="fas fa-crosshairs"></i>
        <span>PENCARIAN RADIUS</span>
    </div>
    
    <div class="alert">
        <i class="fas fa-info-circle"></i>
        Klik pada peta untuk menentukan titik pusat pencarian
    </div>
    
    <div class="form-group">
        <label for="radiusKm">
            <i class="fas fa-ruler"></i> RADIUS (KM)
        </label>
        <input type="number" id="radiusKm" class="form-control" placeholder="Radius dalam kilometer" value="2" min="0.1" max="20" step="0.1">
    </div>
    
    <button id="btnRadiusSearch" class="btn btn-success" disabled>
        <i class="fas fa-bullseye"></i> Cari dalam Radius
    </button>
</div>

<!-- Add Point Section -->
<div class="form-section">
    <div class="section-title">
        <i class="fas fa-plus-circle"></i>
        <span>MANAJEMEN DATA</span>
    </div>
    
    <button id="btnAddMode" class="btn btn-warning">
        <i class="fas fa-map-marker-alt"></i> Tambah Fasilitas Baru
    </button>
    
    <div class="alert" id="addModeInfo" style="display: none;">
        <i class="fas fa-mouse-pointer"></i>
        Klik pada peta untuk menentukan lokasi fasilitas baru
    </div>
</div>

<!-- Reset Button -->
<button id="btnReset" class="btn btn-secondary">
    <i class="fas fa-redo-alt"></i> Reset Semua Filter
</button>

<!-- Divider -->
<div class="divider"></div>
@endsection

@section('content')
<div id="map"></div>
@endsection

@section('modal')
<div class="modal fade" id="pointModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-hospital me-2"></i> 
                    <span id="pointModalTitle">Tambah Fasilitas Kesehatan</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="pointForm">
                    <input type="hidden" id="pointId">
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nama Fasilitas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namaObjek" placeholder="Contoh: RSUD Dr. Soetomo" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="kategoriId" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="latitude" step="0.000001" required>
                                <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="longitude" step="0.000001" required>
                                <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <select class="form-select" id="kecamatanId">
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" placeholder="Contoh: 031-1234567">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" rows="2" placeholder="Jl. Contoh No. 123"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Fasilitas</label>
                        <textarea class="form-control" id="deskripsi" rows="3" placeholder="Deskripsi fasilitas, layanan, dan informasi tambahan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSavePoint">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize map with light theme
    const map = L.map('map').setView([-7.2575, 112.7521], 13);
    
    // Define base layers
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19,
        name: 'OpenStreetMap'
    });
    
    const cartoDBLight = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors, © CARTO',
        maxZoom: 19,
        subdomains: 'abcd',
        name: 'CartoDB Light'
    });
    
    const cartoDBDark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors, © CARTO',
        maxZoom: 19,
        subdomains: 'abcd',
        name: 'CartoDB Dark'
    });
    
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri',
        maxZoom: 19,
        name: 'Satellite'
    });
    
    // Add default layer
    cartoDBLight.addTo(map);
    
    // Layer groups for data
    const pointsLayer = L.layerGroup().addTo(map);
    const searchLayer = L.layerGroup().addTo(map);
    
    // Base layers for layer control
    const baseLayers = {
        'OpenStreetMap': osmLayer,
        'CartoDB Light': cartoDBLight,
        'CartoDB Dark': cartoDBDark,
        'Satellite': satelliteLayer
    };
    
    // Add layer control to map
    L.control.layers(baseLayers, {}, {
        position: 'topright',
        collapsed: true
    }).addTo(map);
    
    // State variables
    let addMode = false;
    let searchCenter = null;
    let searchMarker = null;
    let radiusCircle = null;
    let allPoints = [];
    let visiblePoints = 0;
    
    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Load all points
    function loadPoints() {
        $.get('/api/points', function(data) {
            pointsLayer.clearLayers();
            allPoints = data.features;
            $('#totalObjek').text(allPoints.length);
            visiblePoints = allPoints.length;
            $('#visibleCount').text(visiblePoints);
            
            data.features.forEach(function(feature) {
                addPointToMap(feature);
            });
        }).fail(function() {
            console.error('Failed to load points');
            // Show sample data if API fails
            showSampleData();
        });
    }
    
    // Show sample data (for demo purposes)
    function showSampleData() {
        const sampleData = [
            {
                geometry: { coordinates: [112.7521, -7.2575] },
                properties: {
                    id: 1,
                    nama_objek: 'RSUD Dr. Soetomo',
                    kategori: 'Rumah Sakit',
                    kecamatan: 'Gubeng',
                    alamat: 'Jl. Mayjen Prof. Dr. Moestopo No.6-8',
                    telepon: '031-5501078',
                    deskripsi: 'Rumah sakit umum daerah terbesar di Surabaya'
                }
            },
            {
                geometry: { coordinates: [112.7365, -7.2812] },
                properties: {
                    id: 2,
                    nama_objek: 'RS Darmo',
                    kategori: 'Rumah Sakit',
                    kecamatan: 'Wonokromo',
                    alamat: 'Jl. Raya Darmo No.90',
                    telepon: '031-5676251',
                    deskripsi: 'Rumah sakit swasta'
                }
            },
            {
                geometry: { coordinates: [112.7689, -7.2954] },
                properties: {
                    id: 3,
                    nama_objek: 'Puskesmas Dupak',
                    kategori: 'Puskesmas',
                    kecamatan: 'Bubutan',
                    alamat: 'Jl. Dupak No.65',
                    telepon: '031-3539009',
                    deskripsi: 'Pusat kesehatan masyarakat'
                }
            }
        ];
        
        sampleData.forEach(function(feature) {
            addPointToMap(feature);
        });
        
        $('#totalObjek').text(sampleData.length);
        visiblePoints = sampleData.length;
        $('#visibleCount').text(visiblePoints);
    }
    
    // Add point marker to map
    function addPointToMap(feature) {
        const props = feature.properties;
        const coords = feature.geometry.coordinates;
        
        // Custom icon based on category
        let iconColor = '#00c9a7';
        let iconClass = 'fas fa-hospital';
        
        if (props.kategori) {
            if (props.kategori.toLowerCase().includes('rumah sakit')) {
                iconColor = '#42a5f5';
                iconClass = 'fas fa-hospital-alt';
            } else if (props.kategori.toLowerCase().includes('klinik')) {
                iconColor = '#00d2b5';
                iconClass = 'fas fa-clinic-medical';
            } else if (props.kategori.toLowerCase().includes('puskesmas')) {
                iconColor = '#9575cd';
                iconClass = 'fas fa-first-aid';
            } else if (props.kategori.toLowerCase().includes('apotek')) {
                iconColor = '#2196f3';
                iconClass = 'fas fa-pills';
            }
        }
        
        // Create custom marker
        const customIcon = L.divIcon({
            html: `<div style="
                background: linear-gradient(135deg, ${iconColor}, ${iconColor}dd);
                width: 42px;
                height: 42px;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 18px;
                transition: all 0.3s ease;
            "><i class="${iconClass}"></i></div>`,
            className: 'custom-marker',
            iconSize: [42, 42],
            iconAnchor: [21, 42]
        });
        
        const marker = L.marker([coords[1], coords[0]], {
            title: props.nama_objek,
            icon: customIcon,
            riseOnHover: true
        }).addTo(pointsLayer);
        
        // Popup content
        const popupContent = `
            <div class="popup-title">${props.nama_objek}</div>
            <div class="popup-info">
                <i class="fas fa-tag"></i>
                <div>
                    <strong>Kategori:</strong><br>
                    ${props.kategori}
                </div>
            </div>
            <div class="popup-info">
                <i class="fas fa-map-pin"></i>
                <div>
                    <strong>Lokasi:</strong><br>
                    ${props.kecamatan || 'Tidak ditentukan'}
                </div>
            </div>
            ${props.alamat ? `
            <div class="popup-info">
                <i class="fas fa-location-dot"></i>
                <div>
                    <strong>Alamat:</strong><br>
                    ${props.alamat}
                </div>
            </div>` : ''}
            ${props.telepon ? `
            <div class="popup-info">
                <i class="fas fa-phone"></i>
                <div>
                    <strong>Telepon:</strong><br>
                    ${props.telepon}
                </div>
            </div>` : ''}
            ${props.deskripsi ? `
            <div class="popup-info">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Deskripsi:</strong><br>
                    ${props.deskripsi}
                </div>
            </div>` : ''}
            <div class="popup-actions">
                <button class="btn btn-primary btn-sm" onclick="editPoint(${props.id})" style="padding: 8px 12px; font-size: 12px;">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" onclick="deletePoint(${props.id})" style="padding: 8px 12px; font-size: 12px;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        `;
        
        marker.bindPopup(popupContent, {
            maxWidth: 300,
            minWidth: 250
        });
    }
    
    // Search by attribute
    $('#btnSearch').click(function() {
        const nama = $('#searchNama').val();
        const kategori = $('#filterKategori').val();
        const kecamatan = $('#filterKecamatan').val();
        
        $.get('/api/search/attribute', {
            nama: nama,
            kategori_id: kategori,
            kecamatan_id: kecamatan
        }, function(response) {
            pointsLayer.clearLayers();
            searchLayer.clearLayers();
            
            if (response.data.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ditemukan',
                    text: 'Tidak ada fasilitas yang sesuai dengan kriteria pencarian',
                    confirmButtonColor: '#42a5f5'
                });
                loadPoints();
                return;
            }
            
            response.data.forEach(function(point) {
                const feature = {
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [point.longitude, point.latitude]
                    },
                    properties: {
                        id: point.id,
                        nama_objek: point.nama_objek,
                        kategori: point.kategori.nama_kategori,
                        kecamatan: point.kecamatan ? point.kecamatan.nama_kecamatan : '',
                        deskripsi: point.deskripsi,
                        alamat: point.alamat,
                        telepon: point.telepon
                    }
                };
                addPointToMap(feature);
            });
            
            visiblePoints = response.data.length;
            $('#visibleCount').text(visiblePoints);
            
            Swal.fire({
                icon: 'success',
                title: 'Hasil Pencarian',
                text: `Ditemukan ${response.count} fasilitas kesehatan`,
                confirmButtonColor: '#00d2b5',
                timer: 2000
            });
        });
    });
    
    // Map click for radius search center
    map.on('click', function(e) {
        if (addMode) {
            // Add mode - open modal with coordinates
            $('#pointModalTitle').text('Tambah Fasilitas Baru');
            $('#pointId').val('');
            $('#pointForm')[0].reset();
            $('#latitude').val(e.latlng.lat.toFixed(6));
            $('#longitude').val(e.latlng.lng.toFixed(6));
            $('#pointModal').modal('show');
        } else {
            // Set search center
            searchCenter = e.latlng;
            
            if (searchMarker) {
                map.removeLayer(searchMarker);
            }
            
            // Create search center marker
            searchMarker = L.marker([e.latlng.lat, e.latlng.lng], {
                icon: L.divIcon({
                    html: `<div style="
                        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        border: 4px solid white;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-size: 24px;
                        animation: pulse 1.5s infinite;
                    "><i class="fas fa-crosshairs"></i></div>
                    <style>
                        @keyframes pulse {
                            0% { transform: scale(1); }
                            50% { transform: scale(1.1); }
                            100% { transform: scale(1); }
                        }
                    </style>`,
                    className: 'search-center-marker',
                    iconSize: [50, 50],
                    iconAnchor: [25, 50]
                }),
                zIndexOffset: 1000
            }).addTo(map);
            
            searchMarker.bindPopup('<strong>Titik Pusat Pencarian</strong><br>Klik tombol "Cari dalam Radius"').openPopup();
            $('#btnRadiusSearch').prop('disabled', false);
        }
    });
    
    // Radius search
    $('#btnRadiusSearch').click(function() {
        if (!searchCenter) {
            Swal.fire({
                icon: 'error',
                title: 'Titik belum ditentukan',
                text: 'Klik pada peta untuk menentukan titik pusat pencarian',
                confirmButtonColor: '#ff6b6b'
            });
            return;
        }
        
        const radius = parseFloat($('#radiusKm').val());
        
        $.get('/api/search/radius', {
            latitude: searchCenter.lat,
            longitude: searchCenter.lng,
            radius: radius
        }, function(response) {
            pointsLayer.clearLayers();
            searchLayer.clearLayers();
            
            // Draw radius circle
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
            }
            
            radiusCircle = L.circle([searchCenter.lat, searchCenter.lng], {
                radius: radius * 1000,
                color: '#00c9a7',
                fillColor: '#00c9a7',
                fillOpacity: 0.1,
                weight: 2,
                dashArray: '5, 5'
            }).addTo(searchLayer);
            
            // Add search center marker again
            if (searchMarker) {
                searchMarker.addTo(map);
            }
            
            if (response.data.length === 0) {
                visiblePoints = 0;
                $('#visibleCount').text(0);
                $('#radiusCount').text(0);
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ada fasilitas',
                    text: `Tidak ditemukan fasilitas kesehatan dalam radius ${radius} km`,
                    confirmButtonColor: '#42a5f5'
                });
                return;
            }
            
            response.data.forEach(function(point) {
                const feature = {
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [point.longitude, point.latitude]
                    },
                    properties: {
                        id: point.id,
                        nama_objek: point.nama_objek + ` (${point.distance.toFixed(2)} km)`,
                        kategori: point.kategori.nama_kategori,
                        kecamatan: point.kecamatan ? point.kecamatan.nama_kecamatan : '',
                        deskripsi: point.deskripsi,
                        alamat: point.alamat,
                        telepon: point.telepon
                    }
                };
                addPointToMap(feature);
            });
            
            visiblePoints = response.data.length;
            $('#visibleCount').text(visiblePoints);
            $('#radiusCount').text(response.data.length);
            
            Swal.fire({
                icon: 'success',
                title: 'Hasil Pencarian Radius',
                text: `Ditemukan ${response.count} fasilitas dalam radius ${radius} km`,
                confirmButtonColor: '#00d2b5',
                timer: 2500
            });
        });
    });
    
    // Toggle add mode
    $('#btnAddMode').click(function() {
        addMode = !addMode;
        if (addMode) {
            $(this).removeClass('btn-warning').addClass('btn-danger');
            $(this).html('<i class="fas fa-times"></i> Batalkan Mode Tambah');
            $('#addModeInfo').show();
            map.getContainer().style.cursor = 'crosshair';
            
            Swal.fire({
                icon: 'info',
                title: 'Mode Tambah Aktif',
                text: 'Klik pada peta untuk menentukan lokasi fasilitas baru',
                confirmButtonColor: '#9575cd',
                timer: 2000
            });
        } else {
            $(this).removeClass('btn-danger').addClass('btn-warning');
            $(this).html('<i class="fas fa-map-marker-alt"></i> Tambah Fasilitas Baru');
            $('#addModeInfo').hide();
            map.getContainer().style.cursor = '';
        }
    });
    
    // Save point
    $('#btnSavePoint').click(function() {
        const pointId = $('#pointId').val();
        const data = {
            nama_objek: $('#namaObjek').val(),
            kategori_id: $('#kategoriId').val(),
            latitude: $('#latitude').val(),
            longitude: $('#longitude').val(),
            kecamatan_id: $('#kecamatanId').val() || null,
            alamat: $('#alamat').val(),
            telepon: $('#telepon').val(),
            deskripsi: $('#deskripsi').val()
        };
        
        // Validation
        if (!data.nama_objek || !data.kategori_id || !data.latitude || !data.longitude) {
            Swal.fire({
                icon: 'error',
                title: 'Data tidak lengkap',
                text: 'Harap isi semua field yang wajib diisi',
                confirmButtonColor: '#ff6b6b'
            });
            return;
        }
        
        const url = pointId ? `/api/objek-point/${pointId}` : '/api/objek-point';
        const method = pointId ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(response) {
                $('#pointModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    confirmButtonColor: '#00d2b5',
                    timer: 2000
                });
                loadPoints();
                addMode = false;
                $('#btnAddMode').removeClass('btn-danger').addClass('btn-warning');
                $('#btnAddMode').html('<i class="fas fa-map-marker-alt"></i> Tambah Fasilitas Baru');
                $('#addModeInfo').hide();
                map.getContainer().style.cursor = '';
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    confirmButtonColor: '#ff6b6b'
                });
            }
        });
    });
    
    // Edit point
    window.editPoint = function(id) {
        $.get(`/api/objek-point/${id}`, function(point) {
            $('#pointModalTitle').text('Edit Fasilitas');
            $('#pointId').val(point.id);
            $('#namaObjek').val(point.nama_objek);
            $('#kategoriId').val(point.kategori_id);
            $('#latitude').val(point.latitude);
            $('#longitude').val(point.longitude);
            $('#kecamatanId').val(point.kecamatan_id);
            $('#alamat').val(point.alamat);
            $('#telepon').val(point.telepon);
            $('#deskripsi').val(point.deskripsi);
            $('#pointModal').modal('show');
        });
    };
    
    // Delete point
    window.deletePoint = function(id) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Apakah Anda yakin ingin menghapus fasilitas ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6b6b',
            cancelButtonColor: '#42a5f5',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/objek-point/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message,
                            confirmButtonColor: '#00d2b5',
                            timer: 2000
                        });
                        loadPoints();
                    }
                });
            }
        });
    };
    
    // Reset view
    $('#btnReset').click(function() {
        searchLayer.clearLayers();
        if (searchMarker) {
            map.removeLayer(searchMarker);
        }
        if (radiusCircle) {
            map.removeLayer(radiusCircle);
            radiusCircle = null;
        }
        searchCenter = null;
        $('#btnRadiusSearch').prop('disabled', true);
        $('#searchNama').val('');
        $('#filterKategori').val('').trigger('change');
        $('#filterKecamatan').val('');
        $('#radiusKm').val('2');
        $('#radiusCount').text('0');
        loadPoints();
        map.setView([-7.2575, 112.7521], 13);
        
        Swal.fire({
            icon: 'success',
            title: 'Reset Berhasil',
            text: 'Semua filter dan pencarian telah direset',
            confirmButtonColor: '#718096',
            timer: 1500
        });
    });
    
    // Initial load
    loadPoints();

// === SELECT2 DENGAN IKON KATEGORI ===
function formatKategori(option) {
    if (!option.id) return option.text;

    const icon = $(option.element).data('icon');
    if (!icon) return option.text;

    return $(`
        <span>
            <i class="${icon}" style="margin-right:8px;"></i>
            ${option.text}
        </span>
    `);
}

$('#filterKategori').select2({
    width: '100%',
    templateResult: formatKategori,
    templateSelection: formatKategori,
    minimumResultsForSearch: Infinity
});


</script>
@endsection
