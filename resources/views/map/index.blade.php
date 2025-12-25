@extends('layouts.app')

@section('title', 'Peta GIS Hospital Surabaya')

@section('content')
<div id="map"></div>

<div class="sidebar">
    <div class="sidebar-header">
        <h5 class="mb-0"><i class="fas fa-map-marked-alt"></i> GIS Hospital Surabaya</h5>
        <small>Sistem Informasi Geografis Fasilitas Kesehatan</small>
    </div>
    
    <div class="sidebar-body">
        <!-- Search Section -->
        <div class="filter-section">
            <h6><i class="fas fa-search"></i> Pencarian</h6>
            <input type="text" id="searchNama" class="form-control form-control-sm mb-2" placeholder="Cari berdasarkan nama...">
            
            <select id="filterKategori" class="form-select form-select-sm mb-2">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            
            <select id="filterKecamatan" class="form-select form-select-sm mb-2">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                @endforeach
            </select>
            
            <button id="btnSearch" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
        
        <!-- Radius Search Section -->
        <div class="filter-section">
            <h6><i class="fas fa-crosshairs"></i> Pencarian Radius</h6>
            <div class="alert alert-info alert-sm p-2">
                <small>Klik peta untuk set titik pusat pencarian</small>
            </div>
            <input type="number" id="radiusKm" class="form-control form-control-sm mb-2" placeholder="Radius (km)" value="5" min="0.1" max="50" step="0.1">
            <button id="btnRadiusSearch" class="btn btn-success btn-sm w-100" disabled>
                <i class="fas fa-circle-notch"></i> Cari dalam Radius
            </button>
        </div>
        
        <!-- Add Point Section -->
        <div class="filter-section">
            <h6><i class="fas fa-plus-circle"></i> Tambah Data</h6>
            <button id="btnAddMode" class="btn btn-warning btn-sm w-100">
                <i class="fas fa-map-marker-alt"></i> Aktifkan Mode Tambah
            </button>
            <div class="alert alert-warning alert-sm p-2 mt-2" id="addModeInfo" style="display: none;">
                <small>Klik peta untuk menambahkan marker baru</small>
            </div>
        </div>
        
        <!-- Reset Button -->
        <button id="btnReset" class="btn btn-secondary btn-sm w-100">
            <i class="fas fa-redo"></i> Reset Tampilan
        </button>
        
        <!-- Stats -->
        <div class="mt-3 p-2 bg-light rounded">
            <small><strong>Total Objek:</strong> <span id="totalObjek">0</span></small>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Point -->
<div class="modal fade" id="pointModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pointModalTitle">Tambah Objek Point</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="pointForm">
                    <input type="hidden" id="pointId">
                    <div class="mb-3">
                        <label class="form-label">Nama Objek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="namaObjek" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategoriId" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="latitude" step="0.000001" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="longitude" step="0.000001" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select class="form-select" id="kecamatanId">
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSavePoint">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize map centered on Surabaya
    const map = L.map('map').setView([-7.2575, 112.7521], 12);
    
    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Layer groups
    let pointsLayer = L.layerGroup().addTo(map);
    let linesLayer = L.layerGroup().addTo(map);
    let polygonsLayer = L.layerGroup().addTo(map);
    let searchLayer = L.layerGroup().addTo(map);
    
    // State variables
    let addMode = false;
    let searchCenter = null;
    let searchMarker = null;
    let allPoints = [];
    
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
            
            data.features.forEach(function(feature) {
                addPointToMap(feature);
            });
        });
    }
    
    // Add point marker to map
    function addPointToMap(feature) {
        const props = feature.properties;
        const coords = feature.geometry.coordinates;
        
        const marker = L.marker([coords[1], coords[0]], {
            title: props.nama_objek
        }).addTo(pointsLayer);
        
        const popupContent = `
            <div class="popup-title">${props.nama_objek}</div>
            <div class="popup-info"><i class="fas fa-tag"></i> ${props.kategori}</div>
            <div class="popup-info"><i class="fas fa-map-pin"></i> ${props.kecamatan || 'N/A'}</div>
            ${props.alamat ? `<div class="popup-info"><i class="fas fa-location-dot"></i> ${props.alamat}</div>` : ''}
            ${props.telepon ? `<div class="popup-info"><i class="fas fa-phone"></i> ${props.telepon}</div>` : ''}
            ${props.deskripsi ? `<div class="popup-info">${props.deskripsi}</div>` : ''}
            <div class="popup-actions">
                <button class="btn btn-sm btn-primary" onclick="editPoint(${props.id})">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger" onclick="deletePoint(${props.id})">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        `;
        
        marker.bindPopup(popupContent);
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
                Swal.fire('Info', 'Tidak ada hasil ditemukan', 'info');
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
            
            Swal.fire('Sukses', `Ditemukan ${response.count} hasil`, 'success');
        });
    });
    
    // Map click for radius search center
    map.on('click', function(e) {
        if (addMode) {
            // Add mode - open modal with coordinates
            $('#pointModalTitle').text('Tambah Objek Point');
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
            
            searchMarker = L.marker([e.latlng.lat, e.latlng.lng], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41]
                })
            }).addTo(map);
            
            searchMarker.bindPopup('Titik Pusat Pencarian').openPopup();
            $('#btnRadiusSearch').prop('disabled', false);
        }
    });
    
    // Radius search
    $('#btnRadiusSearch').click(function() {
        if (!searchCenter) {
            Swal.fire('Error', 'Klik peta untuk menentukan titik pusat pencarian', 'error');
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
            
            // Draw circle
            L.circle([searchCenter.lat, searchCenter.lng], {
                radius: radius * 1000, // convert to meters
                color: 'blue',
                fillColor: '#3388ff',
                fillOpacity: 0.1
            }).addTo(searchLayer);
            
            if (response.data.length === 0) {
                Swal.fire('Info', 'Tidak ada objek dalam radius tersebut', 'info');
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
            
            Swal.fire('Sukses', `Ditemukan ${response.count} objek dalam radius ${radius} km`, 'success');
        });
    });
    
    // Toggle add mode
    $('#btnAddMode').click(function() {
        addMode = !addMode;
        if (addMode) {
            $(this).removeClass('btn-warning').addClass('btn-danger');
            $(this).html('<i class="fas fa-times"></i> Nonaktifkan Mode Tambah');
            $('#addModeInfo').show();
            map.getContainer().style.cursor = 'crosshair';
        } else {
            $(this).removeClass('btn-danger').addClass('btn-warning');
            $(this).html('<i class="fas fa-map-marker-alt"></i> Aktifkan Mode Tambah');
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
        
        const url = pointId ? `/api/objek-point/${pointId}` : '/api/objek-point';
        const method = pointId ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(response) {
                $('#pointModal').modal('hide');
                Swal.fire('Sukses', response.message, 'success');
                loadPoints();
                addMode = false;
                $('#btnAddMode').removeClass('btn-danger').addClass('btn-warning');
                $('#btnAddMode').html('<i class="fas fa-map-marker-alt"></i> Aktifkan Mode Tambah');
                $('#addModeInfo').hide();
                map.getContainer().style.cursor = '';
            },
            error: function(xhr) {
                Swal.fire('Error', 'Gagal menyimpan data', 'error');
            }
        });
    });
    
    // Edit point
    window.editPoint = function(id) {
        $.get(`/api/objek-point/${id}`, function(point) {
            $('#pointModalTitle').text('Edit Objek Point');
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
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus objek ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/objek-point/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire('Terhapus!', response.message, 'success');
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
        searchCenter = null;
        $('#btnRadiusSearch').prop('disabled', true);
        $('#searchNama').val('');
        $('#filterKategori').val('');
        $('#filterKecamatan').val('');
        loadPoints();
        map.setView([-7.2575, 112.7521], 12);
    });
    
    // Initial load
    loadPoints();
</script>
@endsection
