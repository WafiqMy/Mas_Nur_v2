<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - Masjid Nurul Huda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; min-height: 100vh; display: flex; align-items: center; }
        .card-reset { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .form-control { border-radius: 12px; padding: 14px 14px 14px 50px; border: 1px solid #e2e8f0; background-color: #f8fafc; transition: all 0.3s; }
        .form-control:focus { background-color: #fff; border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
        .input-icon { position: absolute; z-index: 10; top: 50%; transform: translateY(-50%); left: 15px; color: #94a3b8; }
        .btn-action { background-color: #2563eb; color: white; border-radius: 12px; padding: 14px; width: 100%; font-weight: 600; border: none; transition: all 0.3s; }
        .btn-action:hover { background-color: #1d4ed8; transform: translateY(-2px); }
        .step-section { display: none; }
        .step-active { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .otp-input-group { display: flex; gap: 10px; justify-content: center; margin: 20px 0; }
        .otp-box { width: 50px; height: 60px; font-size: 24px; font-weight: 700; text-align: center; border: 2px solid #e2e8f0; border-radius: 12px; background-color: #f8fafc; transition: all 0.3s; }
        .otp-box:focus { border-color: #2563eb; background-color: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); outline: none; }
        .password-toggle { position: absolute; z-index: 10; top: 50%; transform: translateY(-50%); right: 15px; color: #94a3b8; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-reset p-4 p-md-5">

                {{-- STEP 1: Email --}}
                <div id="step1" class="step-section step-active">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Lupa Kata Sandi?</h3>
                        <p class="text-muted">Masukkan email terdaftar untuk mendapatkan kode OTP.</p>
                    </div>
                    <div class="mb-4">
                        <div class="position-relative">
                            <span class="input-icon"><i class="far fa-envelope"></i></span>
                            <input type="email" id="email" class="form-control" placeholder="Email Terdaftar" required>
                        </div>
                    </div>
                    <button class="btn-action" onclick="requestOtp()">
                        Kirim Kode OTP <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </div>

                {{-- STEP 2: OTP --}}
                <div id="step2" class="step-section">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Verifikasi OTP</h3>
                        <p class="text-muted">Masukkan 6 digit kode yang dikirim ke email Anda.</p>
                    </div>
                    <div class="otp-input-group">
                        @for($i = 1; $i <= 6; $i++)
                        <input type="text" class="otp-box" maxlength="1" id="otp{{ $i }}"
                               oninput="pindah(this, {{ $i < 6 ? "'otp".($i+1)."'" : "'done'" }})">
                        @endfor
                    </div>
                    <button class="btn-action" onclick="verifyOtp()">
                        Verifikasi Kode
                    </button>
                    <div class="text-center mt-3">
                        <small class="text-muted">Tidak menerima?
                            <a href="#" onclick="switchStep(1)" class="text-primary text-decoration-none">Kirim Ulang</a>
                        </small>
                    </div>
                </div>

                {{-- STEP 3: Password Baru --}}
                <div id="step3" class="step-section">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Buat Sandi Baru</h3>
                        <p class="text-muted">Buat kata sandi baru yang kuat.</p>
                    </div>
                    <div class="mb-3">
                        <div class="position-relative">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" id="pass1" class="form-control" placeholder="Kata Sandi Baru" style="padding-right: 45px;">
                            <span class="password-toggle" onclick="togglePass('pass1','icon1')">
                                <i class="far fa-eye" id="icon1"></i>
                            </span>
                        </div>
                        <div id="pass1Error" class="text-danger small mt-1" style="display:none;"></div>
                    </div>
                    <div class="mb-4">
                        <div class="position-relative">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" id="pass2" class="form-control" placeholder="Konfirmasi Sandi Baru" style="padding-right: 45px;">
                            <span class="password-toggle" onclick="togglePass('pass2','icon2')">
                                <i class="far fa-eye" id="icon2"></i>
                            </span>
                        </div>
                        <div id="pass2Error" class="text-danger small mt-1" style="display:none;"></div>
                    </div>
                    <button class="btn-action" onclick="resetPassword()">
                        Simpan & Masuk
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let userEmail = '', userOtp = '';
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    function switchStep(n) {
        document.querySelectorAll('.step-section').forEach(el => el.classList.remove('step-active'));
        document.getElementById('step' + n).classList.add('step-active');
    }

    function pindah(el, nextId) {
        if (el.value.length >= 1 && nextId !== 'done') document.getElementById(nextId).focus();
    }

    function togglePass(fieldId, iconId) {
        const f = document.getElementById(fieldId);
        const i = document.getElementById(iconId);
        f.type = f.type === 'password' ? 'text' : 'password';
        i.classList.toggle('fa-eye'); i.classList.toggle('fa-eye-slash');
    }

    async function requestOtp() {
        userEmail = document.getElementById('email').value;
        if (!userEmail) { Swal.fire('Perhatian', 'Masukkan email Anda.', 'warning'); return; }

        Swal.fire({ title: 'Mengirim OTP...', didOpen: () => Swal.showLoading() });

        const res = await fetch('{{ route("lupa-password.request-otp") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ email: userEmail })
        });
        const data = await res.json();

        if (data.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, confirmButtonColor: '#2563eb' })
                .then(() => switchStep(2));
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
        }
    }

    async function verifyOtp() {
        let otp = '';
        for (let i = 1; i <= 6; i++) otp += document.getElementById('otp' + i).value;
        if (otp.length < 6) { Swal.fire('Perhatian', 'Masukkan 6 digit OTP.', 'warning'); return; }

        Swal.fire({ title: 'Memverifikasi...', didOpen: () => Swal.showLoading() });

        const res = await fetch('{{ route("lupa-password.verify-otp") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ email: userEmail, otp })
        });
        const data = await res.json();

        if (data.status === 'success') {
            userOtp = otp;
            Swal.close();
            switchStep(3);
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
        }
    }

    async function resetPassword() {
        const p1 = document.getElementById('pass1').value;
        const p2 = document.getElementById('pass2').value;
        const e1 = document.getElementById('pass1Error');
        const e2 = document.getElementById('pass2Error');
        e1.style.display = 'none'; e2.style.display = 'none';

        let valid = true;
        if (p1.length < 8 || !/[a-zA-Z]/.test(p1) || !/\d/.test(p1)) {
            e1.textContent = 'Password minimal 8 karakter, kombinasi huruf dan angka.';
            e1.style.display = 'block'; valid = false;
        }
        if (p1 !== p2) {
            e2.textContent = 'Konfirmasi password tidak sama.';
            e2.style.display = 'block'; valid = false;
        }
        if (!valid) return;

        Swal.fire({ title: 'Menyimpan...', didOpen: () => Swal.showLoading() });

        const res = await fetch('{{ route("lupa-password.reset") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ email: userEmail, otp: userOtp, password: p1 })
        });
        const data = await res.json();

        if (data.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Sukses!', text: 'Password berhasil diubah.', confirmButtonColor: '#2563eb' })
                .then(() => window.location.href = '{{ route("login") }}');
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
        }
    }
</script>
</body>
</html>
