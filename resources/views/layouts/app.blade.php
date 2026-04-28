<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masjid Nurul Huda')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-color: #2563eb;
            --brand-hover: #1d4ed8;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8f9fa;
        }
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 76px;
            background-color: #fff;
            overflow-x: hidden;
        }
        .navbar-brand img { height: 40px; }
        .nav-link { font-weight: 500; color: var(--text-dark) !important; transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--brand-color) !important; }
        .btn-brand { background-color: var(--brand-color); color: #fff; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; transition: all 0.2s; }
        .btn-brand:hover { background-color: var(--brand-hover); color: #fff; transform: translateY(-1px); }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: #ef4444; color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; }
        .alert-flash { position: fixed; top: 90px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.navbar')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-flash shadow" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-flash shadow" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-flash shadow" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true });

        // Auto-dismiss flash alerts
        setTimeout(() => {
            document.querySelectorAll('.alert-flash').forEach(el => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                bsAlert.close();
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>
