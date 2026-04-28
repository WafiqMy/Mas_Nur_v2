<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Masjid Nurul Huda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); min-height: 100vh; display: flex; align-items: center; }
        .card-otp { border: none; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .otp-input-group { display: flex; gap: 12px; justify-content: center; margin: 20px 0; }
        .otp-box { width: 55px; height: 65px; font-size: 26px; font-weight: 700; text-align: center; border: 2px solid #e2e8f0; border-radius: 12px; background-color: #f8fafc; color: #1e293b; transition: all 0.3s; }
        .otp-box:focus { border-color: #2563eb; background-color: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); outline: none; transform: scale(1.05); }
        .btn-verify { background-color: #2563eb; color: white; border-radius: 12px; padding: 14px; width: 100%; font-weight: 600; border: none; font-size: 1rem; transition: all 0.3s; }
        .btn-verify:hover { background-color: #1d4ed8; transform: translateY(-2px); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-otp p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;">
                        <i class="bi bi-shield-check text-primary fs-2"></i>
                    </div>
                    <h3 class="fw-bold">Verifikasi OTP</h3>
                    <p class="text-muted">Masukkan 6 digit kode yang dikirim ke<br><strong>{{ $email }}</strong></p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('verifikasi.post') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="otp-input-group">
                        @for($i = 1; $i <= 6; $i++)
                        <input type="text" class="otp-box" maxlength="1" id="otp{{ $i }}"
                               oninput="pindah(this, {{ $i < 6 ? "'otp".($i+1)."'" : "'done'" }})">
                        @endfor
                    </div>

                    <input type="hidden" name="otp" id="otpFull">

                    <button type="submit" class="btn-verify" onclick="gabungOtp()">
                        Verifikasi <i class="bi bi-check-circle ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <small class="text-muted">Tidak menerima kode?
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar ulang</a>
                    </small>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script>
    function pindah(el, nextId) {
        if (el.value.length >= 1 && nextId !== 'done') {
            document.getElementById(nextId).focus();
        }
    }
    function gabungOtp() {
        let otp = '';
        for (let i = 1; i <= 6; i++) {
            otp += document.getElementById('otp' + i).value;
        }
        document.getElementById('otpFull').value = otp;
    }
</script>
</body>
</html>
