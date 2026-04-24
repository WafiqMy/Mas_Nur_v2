<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Masjid Nurul Huda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .left-panel { background-color: #fff; display: flex; flex-direction: column; justify-content: center; padding: 40px 60px; min-height: 100vh; }
        .right-panel { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; display: flex; flex-direction: column; justify-content: center; padding: 80px; min-height: 100vh; position: relative; }
        .right-panel::before { content: ''; position: absolute; inset: 0; background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .form-title { font-size: 2rem; font-weight: 700; color: #1e293b; }
        .input-icon { position: absolute; z-index: 10; top: 50%; transform: translateY(-50%); left: 15px; color: #94a3b8; }
        .form-control { border-radius: 12px; padding: 14px 14px 14px 50px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 0.95rem; transition: all 0.3s; }
        .form-control:focus { background-color: #fff; border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
        .form-control.is-invalid { border-color: #dc3545; background-image: none !important; }
        .btn-daftar { background-color: #2563eb; color: white; border-radius: 12px; padding: 14px; width: 100%; font-weight: 600; border: none; font-size: 1rem; transition: all 0.3s; }
        .btn-daftar:hover { background-color: #1d4ed8; transform: translateY(-2px); }
        .password-toggle { position: absolute; z-index: 10; top: 50%; transform: translateY(-50%); right: 15px; color: #94a3b8; cursor: pointer; }
        @media (max-width: 991px) { .right-panel { display: none !important; } .left-panel { padding: 30px 20px; } }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">

        <div class="col-lg-5 col-12 left-panel">
            <div style="max-width: 450px; margin: 0 auto; width: 100%;">

                <div class="text-center mb-4">
                    <h2 class="form-title">Buat Akun Baru</h2>
                    <p class="text-muted">Bergabunglah dengan komunitas digital Masjid Nurul Huda</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <div class="position-relative">
                            <span class="input-icon"><i class="far fa-id-card"></i></span>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <span class="input-icon"><i class="far fa-user"></i></span>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   placeholder="Username (Huruf & Angka saja)" value="{{ old('username') }}" required>
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kata Sandi (Min 8 karakter)" required style="padding-right: 45px;">
                            <span class="password-toggle" onclick="togglePass()">
                                <i class="far fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1 ms-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="position-relative">
                            <span class="input-icon"><i class="far fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Alamat Email Aktif" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="position-relative">
                            <span class="input-icon"><i class="fas fa-phone-alt"></i></span>
                            <input type="text" name="no_telpon" class="form-control @error('no_telpon') is-invalid @enderror"
                                   placeholder="Nomor WhatsApp (628...)" value="{{ old('no_telpon') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-daftar">
                        Daftar Sekarang <i class="fas fa-paper-plane ms-2"></i>
                    </button>

                    <div class="text-center mt-4 mb-3">
                        <span class="text-muted">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1" style="color: #2563eb;">Masuk disini</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-flex right-panel">
            <div class="position-relative" style="z-index: 1;">
                <div class="mb-4">
                    <div style="border-left: 4px solid rgba(255,255,255,0.4); height: 80px; margin-right: 25px; display: inline-block; vertical-align: middle;"></div>
                    <span style="font-size: 3.5rem; font-weight: 800; display: inline-block; vertical-align: middle; line-height: 1;">Mas Nur</span>
                </div>
                <h3 class="fw-bold mb-3">Sistem Digital Masjid Nurul Huda</h3>
                <p class="fs-5 lh-lg opacity-75" style="max-width: 600px;">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh.<br>
                    Mari bersama memakmurkan masjid dan mempererat ukhuwah islamiyah melalui layanan digital yang modern dan transparan.
                </p>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePass() {
        const p = document.getElementById('password');
        const i = document.getElementById('toggleIcon');
        p.type = p.type === 'password' ? 'text' : 'password';
        i.classList.toggle('fa-eye');
        i.classList.toggle('fa-eye-slash');
    }
</script>
</body>
</html>
