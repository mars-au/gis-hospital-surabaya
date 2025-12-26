<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital GIS Surabaya')</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --hijau-mint: #00d2b5;
            --hijau-toska: #00c9a7;
            --ungu-soft: #9575cd;
            --ungu-medium: #7e57c2;
            --biru-cerah: #42a5f5;
            --biru-medium: #2196f3;
            --biru-gelap: #1565c0;
            --light-bg: #f8fdff;
            --card-bg: #ffffff;
            --sidebar-bg: linear-gradient(180deg, #ffffff 0%, #f8fdff 100%);
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 18px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 50%, #f0f2ff 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Main Container */
        .main-container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Sidebar */
        .sidebar {
            width: 380px;
            background: var(--sidebar-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 100;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--hijau-mint), var(--ungu-soft), var(--biru-cerah));
            z-index: 101;
        }
        
        .sidebar-header {
            background: linear-gradient(135deg, var(--biru-medium) 0%, var(--ungu-medium) 100%);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .sidebar-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }
        
        .sidebar-header p {
            font-size: 13px;
            opacity: 0.9;
            line-height: 1.5;
            position: relative;
            z-index: 1;
        }
        
        .sidebar-body {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-body::-webkit-scrollbar {
            width: 10px;
        }

        .sidebar-body::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.03);
            border-radius: 999px;
            margin: 6px 0;
        }

        .sidebar-body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--hijau-mint), var(--biru-cerah));
            border-radius: 999px;
            box-shadow: inset 0 0 0 2px rgba(255,255,255,0.18);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .sidebar-body::-webkit-scrollbar-thumb:hover {
            transform: scale(1.05);
            box-shadow: inset 0 0 0 3px rgba(255,255,255,0.22);
        }

        .sidebar-body::-webkit-scrollbar-thumb:active {
            transform: scale(0.98);
        }

        .sidebar-body::-webkit-scrollbar-corner {
            background: transparent;
        }

        /* Firefox */
        .sidebar-body {
            scrollbar-width: thin;
            scrollbar-color: rgba(34,197,94,0.9) rgba(0,0,0,0.06);
        }

        /* Global page scrollbar (subtle) */
        html::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        html::-webkit-scrollbar-track {
            background: transparent;
        }

        html::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(0,0,0,0.12), rgba(0,0,0,0.06));
            border-radius: 999px;
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.15) transparent;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 0;
        }
        
        /* Content Header */
        .content-header {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: 25px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .content-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--hijau-mint), var(--ungu-soft));
        }
        
        .content-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
            background: linear-gradient(90deg, var(--biru-gelap), var(--ungu-medium));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .content-header p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 25px 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--hijau-mint), var(--biru-cerah));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--hijau-toska), var(--biru-cerah));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0, 201, 167, 0.3);
        }
        
        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, var(--ungu-soft), var(--biru-medium));
        }
        
        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, var(--biru-cerah), var(--hijau-mint));
        }
        
        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }
        
        .stat-card p {
            font-size: 13px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        
        /* Map Container */
        .map-container {
            flex: 1;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
        }
        
        #map {
            width: 100%;
            height: 100%;
            border-radius: var(--radius-lg);
        }
        
        /* Form Sections */
        .form-section {
            background: rgba(255, 255, 255, 0.7);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--hijau-mint), var(--biru-cerah));
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(0, 201, 167, 0.1);
        }
        
        .section-title i {
            color: var(--biru-medium);
            background: rgba(66, 165, 245, 0.1);
            padding: 8px;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 14px;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--biru-cerah);
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1);
            background: white;
        }
        
        /* Buttons */
        .btn {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--biru-medium) 0%, var(--biru-gelap) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--hijau-mint) 0%, var(--hijau-toska) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 210, 181, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 181, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--ungu-soft) 0%, var(--ungu-medium) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(149, 117, 205, 0.3);
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(149, 117, 205, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(113, 128, 150, 0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(113, 128, 150, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }
        
        /* Alert */
        .alert {
            background: linear-gradient(135deg, rgba(224, 247, 250, 0.8), rgba(178, 235, 242, 0.8));
            border: 2px solid rgba(0, 188, 212, 0.3);
            border-radius: var(--radius-sm);
            padding: 12px 15px;
            margin: 10px 0;
            font-size: 13px;
            color: #006064;
        }
        
        .alert i {
            color: #00bcd4;
            margin-right: 8px;
        }
        
        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(0, 201, 167, 0.2), transparent);
            margin: 20px 0;
            position: relative;
        }
        
        .divider::before {
            content: '◆';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--hijau-mint);
            background: white;
            padding: 0 10px;
            font-size: 12px;
        }
        
        /* Modal */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
            box-shadow: var(--shadow-lg);
            background: var(--card-bg);
            backdrop-filter: blur(10px);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--biru-medium) 0%, var(--ungu-medium) 100%);
            color: white;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            padding: 20px 25px;
            border: none;
        }
        
        .modal-title {
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                max-height: 500px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .sidebar-header h1 {
                font-size: 20px;
            }
            
            .content-header h2 {
                font-size: 20px;
            }
            
            .stat-card h3 {
                font-size: 28px;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .sidebar, .content-header, .stat-card, .map-container {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Leaflet Popup */
        .leaflet-popup-content-wrapper {
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
        }
        
        .popup-title {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--biru-cerah);
        }
        
        .popup-info {
            margin: 8px 0;
            font-size: 13px;
            color: var(--text-secondary);
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .popup-info i {
            color: var(--biru-medium);
            width: 16px;
            margin-top: 2px;
        }
        
        .popup-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 201, 167, 0.2);
            display: flex;
            gap: 8px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>
                    <i class="fas fa-hospital-alt"></i>
                    Hospital GIS Surabaya
                </h1>
                <p>Sistem Informasi Geografis Fasilitas Kesehatan</p>
            </div>
            
            <div class="sidebar-body">
                @yield('sidebar')
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Content Header -->
            <div class="content-header">
                <h2>Peta Distribusi Fasilitas Kesehatan</h2>
                <p>Visualisasi data rumah sakit, klinik, dan puskesmas berdasarkan lokasi geografis</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h3 id="totalObjek">0</h3>
                    <p>Total Fasilitas</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>{{ count($kecamatans ?? []) }}</h3>
                    <p>Kecamatan</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3>{{ count($kategoris ?? []) }}</h3>
                    <p>Kategori</p>
                </div>
            </div>
            
            <!-- Map Container -->
            <div class="map-container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modal -->
    @yield('modal')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('scripts')
</body>
</html>
