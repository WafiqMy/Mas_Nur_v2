@extends('layouts.app')

@section('title', 'Profil Saya - Masjid Nurul Huda')

@push('styles')
<style>
    .card-profile { border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .profile-sidebar { background-color: #fff; text-align: center; padding: 40px 20px; border-right: 1px solid #f0f0f0; }
    .img-wrapper { position: relative; width: 130px; height: 130px; margin: 0 auto 20px; }
    .profile-img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .upload-btn { position: absolute; bottom: 5px; right: 5px; background: #2563eb; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; transition: 0.3s; }
    .upload-btn:hover { background: #1d4ed8; transform: scale(1.1); }
    .profile-name { font-weight: 700; font-size: 1.4rem; color: #333; margin-bottom: 5px; }
    .profile-role { color: #2563eb; font-weight: 700; font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; }
    .profile-content { padding: 40px; }
    .nav-tabs { border-bottom: 1px solid #eee; margin-bottom: 30px; }
    .nav-link { border: none; color: #999; font-weight: 600; margin-right: 15px; }
    .nav-link.active { color: #2563eb; border-bottom: 3px solid #2563eb; background: transparent; }
    .form-label { font-size: 0.75rem; font-weight: 700; color: #777; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { background-color: #f9f9f9; border: 1px solid #eee; padding: 12px; border-radius: 8px; }
    .form-control:focus { background-color: #fff; border-color: #2563eb; box-shadow: none; }
    .btn-custom { background-color: #2563eb; color: white; border: none; padding: 12px; border-radius: 8px; width: 100%; font-weight: 600; margin-top: 15px; }
    .btn-custom:hover { background-color: #1d4ed8; color: white; }
    .password-toggle { position: absolute; z-index: 10; top: 50%; transform: translateY(-50%); right: 15px; color: #94a3b8; cursor: pointer; }
    @media(max-width: 768px) { .profile-sidebar { border-right: none; border-bottom: 1px solid #eee; } .profile-content { padding: 20px; } }
</style>
@endpush

@section('content')
@php
    $sessionUser = session('user');
    $nama     = $profilUser['nama'] ?? $sessionUser['nama'] ?? '';
    $username = $profilUser['username'] ?? $sessionUser['username'] ?? '';
    $role     = $profilUser['role'] ?? $sessionUser['role'] ?? 'user';
    $email    = $profilUser['email'] ?? '';
    $noTelp   = $profilUser['no_telpon'] ?? '';
    $fotoUrl  = $profilUser['gambar_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=2563eb&color=fff&size=128';
@endphp

<div class="container py-5">
    <div class="card card-profile overflow-hidden">
        <div class="row g-0">

            {{-- Sidebar --}}
            <div class="col-md-4 col-lg-3 profile-sidebar">
                <div class="img-wrapper">
                    <img src="{{ $fotoUrl }}" id="displayFoto" class="profile-img" alt="Foto Profil"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=2563eb&color=fff&size=128'">
                    <label for="uploadInput" class="upload-btn" title="Ganti foto">
                        <i class="bi bi-camera"></i>
                    </label>
                    <input type="file" id="uploadInput" style="display:none" accept="image/*">
                </div>
                <h3 class="profile-name">{{ $nama }}</h3>
                <div class="profile-role">{{ $role === 'admin' ? 'ADMINISTRATOR' : 'MEMBER' }}</div>
                <div class="text-muted small mt-1"><i class="bi bi-at me-1"></i>{{ $username }}</div>
            </div>

            {{-- Content --}}
            <div class="col-md-8 col-lg-9 profile-content">
                <ul class="nav nav-tabs" id="profileTab">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                            Info Pribadi
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">
                            Keamanan
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- Info Pribadi --}}
                    <div class="tab-pane fade show active" id="info">
                        <form action="{{ route('profil-user.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control"
                                       value="{{ old('nama', $nama) }}" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor WhatsApp</label>
                                    <input type="text" name="no_telpon" class="form-control"
                                           value="{{ old('no_telpon', $noTelp) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $email) }}" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
                        </form>
                    </div>

                    {{-- Keamanan --}}
                    <div class="tab-pane fade" id="security">
                        <div class="alert alert-light border small text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Kode OTP akan dikirim ke email Anda sebelum mengganti password.
                        </div>

                        <div id="viewRequestOTP">
                            <button type="button" class="btn btn-custom" id="btnKirimOTP">
                                <i class="bi bi-envelope me-2"></i>Kirim Kode OTP
                            </button>
                        </div>

                        <div id="viewChangePass" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Kode OTP</label>
                                <input type="text" class="form-control" id="otpInput"
                                       placeholder="Masukkan kode OTP...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi Baru</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="pass1"
                                           placeholder="Min 8 karakter (Huruf + Angka)"
                                           style="padding-right: 45px;">
                                    <span class="password-toggle" onclick="togglePass('pass1','icon1')">
                                        <i class="bi bi-eye" id="icon1"></i>
                                    </span>
                                </div>
                                <div id="pass1Error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Kata Sandi</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="pass2"
                                           placeholder="Ulangi kata sandi baru"
                                           style="padding-right: 45px;">
                                    <span class="password-toggle" onclick="togglePass('pass2','icon2')">
                                        <i class="bi bi-eye" id="icon2"></i>
                                    </span>
                                </div>
                                <div id="pass2Error" class="text-danger small mt-1" style="display:none;"></div>
                            </div>
                            <button type="button" class="btn btn-success w-100 py-2 fw-bold mt-2"
                                    onclick="gantiPassword()">
                                Konfirmasi & Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const csrf = '{{ csrf_token() }}';

    function togglePass(fieldId, iconId) {
        const f = document.getElementById(fieldId);
        const i = document.getElementById(iconId);
        f.type = f.type === 'password' ? 'text' : 'password';
        i.classList.toggle('bi-eye');
        i.classList.toggle('bi-eye-slash');
    }

    // Upload foto via form submit
    document.getElementById('uploadInput').addEventListener('change', function() {
        if (!this.files.length) return;
        const formData = new FormData();
        formData.append('_token', csrf);
        formData.append('_method', 'POST');
        formData.append('gambar', this.files[0]);
        formData.append('nama', '{{ $nama }}');
        formData.append('email', '{{ $email }}');
        formData.append('no_telpon', '{{ $noTelp }}');

        Swal.fire({ title: 'Mengupload...', didOpen: () => Swal.showLoading() });

        fetch('{{ route("profil-user.update") }}', { method: 'POST', body: formData })
            .then(() => {
                Swal.fire('Berhasil', 'Foto profil diperbarui.', 'success')
                    .then(() => location.reload());
            })
            .catch(() => Swal.fire('Error', 'Gagal upload foto.', 'error'));
    });

    // Kirim OTP
    document.getElementById('btnKirimOTP').addEventListener('click', function() {
        Swal.fire({ title: 'Mengirim OTP...', didOpen: () => Swal.showLoading() });

        fetch('{{ route("profil-user.request-otp") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Terkirim!', data.message, 'success');
                document.getElementById('viewRequestOTP').style.display = 'none';
                document.getElementById('viewChangePass').style.display = 'block';
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });

    // Ganti password
    function gantiPassword() {
        const otp  = document.getElementById('otpInput').value;
        const p1   = document.getElementById('pass1').value;
        const p2   = document.getElementById('pass2').value;
        const e1   = document.getElementById('pass1Error');
        const e2   = document.getElementById('pass2Error');
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

        Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading() });

        fetch('{{ route("profil-user.update-password") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ otp, password_baru: p1 })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Sukses!', 'Password berhasil diubah. Silakan login ulang.', 'success')
                    .then(() => {
                        fetch('{{ route("logout") }}', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf }
                        }).then(() => window.location.href = '{{ route("login") }}');
                    });
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    }
</script>
@endpush
