# 🕌 Masjid Nurul Huda - Sistem Digital (Laravel Frontend)

Aplikasi web sistem informasi Masjid Nurul Huda yang dibangun dengan **Laravel 11** sebagai **frontend framework** yang mengonsumsi **API PHP native** yang sudah ada.

> **Arsitektur:** Laravel berfungsi sebagai **API Consumer** — semua data berasal dari API eksternal di `https://masnurhudanganjuk.pbltifnganjuk.com/API/`. **Tidak ada database lokal yang digunakan.**

---

## 📋 Fitur Utama

| Modul | Deskripsi |
|-------|-----------|
| **Autentikasi** | Login, Register, Verifikasi OTP, Lupa Password (via API) |
| **Berita** | CRUD berita dengan upload foto (Admin) |
| **Acara/Event** | CRUD acara dengan galeri dokumentasi & video (Admin) |
| **Reservasi** | Sewa fasilitas (Gedung, Alat Multimedia, Alat Musik) dengan kalender |
| **Profil Masjid** | Edit profil, sejarah, dan struktur organisasi (Admin) |
| **Notifikasi** | Sistem notifikasi real-time untuk user & admin |
| **Profil User** | Edit profil, foto, dan ganti password via OTP |

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    LARAVEL FRONTEND                         │
│  (Views, Controllers, Routes, Session Management)           │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │           ApiService (HTTP Client)                   │  │
│  │  - Mengirim request ke API eksternal                 │  │
│  │  - Handle response & error                           │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓ HTTP Request
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              API PHP NATIVE (Backend)                       │
│  https://masnurhudanganjuk.pbltifnganjuk.com/API/          │
│                                                              │
│  - api_login_web.php                                        │
│  - api_register.php                                         │
│  - api_tambah_berita.php, api_edit_berita.php, dll         │
│  - api_barang.php, api_simpan_reservasi.php                │
│  - api_landing_content.php                                  │
│  - api_notifikasi_web.php                                   │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │         MySQL Database (Remote)                      │  │
│  │  - akun, berita, event, persewaan, reservasi, dll    │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

---

## 🚀 Cara Instalasi

### 1. Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- **Tidak perlu MySQL lokal** (semua data dari API)

### 2. Clone & Setup

```bash
# Masuk ke folder proyek
cd masjid-nurul-huda

# Install dependencies PHP
composer install

# Install dependencies JS
npm install

# Copy file environment
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Konfigurasi Environment

Edit file `.env`:

```env
APP_NAME="Masjid Nurul Huda"
APP_URL=http://localhost:8000
APP_LOCALE=id

# API Backend URL (PENTING!)
API_BASE_URL=https://masnurhudanganjuk.pbltifnganjuk.com/API

# Database TIDAK digunakan - semua data dari API
# DB_CONNECTION=mysql

# Session menggunakan file (tidak perlu database)
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 4. Build Assets

```bash
# Build untuk production
npm run build

# Atau untuk development (dengan hot reload)
npm run dev
```

### 5. Jalankan Server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 🔌 Endpoint API yang Digunakan

Laravel mengonsumsi API berikut dari backend PHP native:

### Autentikasi
- `POST /api_login_web.php` - Login
- `POST /api_register.php` - Registrasi
- `POST /api_verifikasi.php` - Verifikasi OTP
- `POST /api_lupa_request.php` - Request OTP lupa password
- `POST /api_lupa_verify.php` - Verifikasi OTP lupa password
- `POST /api_lupa_reset.php` - Reset password

### Berita
- `GET /berita-list.php` - List semua berita
- `GET /api_get_berita.php?id={id}` - Detail berita
- `POST /api_tambah_berita.php` - Tambah berita (multipart)
- `POST /api_edit_berita.php` - Edit berita (multipart)
- `GET /api_hapus_berita.php?id_berita={id}` - Hapus berita

### Acara/Event
- `GET /api_get_event.php` - List semua acara
- `GET /api_get_event.php?id={id}` - Detail acara
- `POST /api_tambah_event.php` - Tambah acara (multipart)
- `POST /api_edit_event.php` - Edit acara (multipart)
- `POST /api_hapus_event.php` - Hapus acara (JSON)

### Persewaan/Barang
- `GET /api_barang.php` - List semua barang
- `GET /api_barang.php?jenis={jenis}` - Filter by jenis
- `POST /api_tambah_barang.php` - Tambah barang (multipart)
- `POST /api_edit_barang.php` - Edit barang (multipart)
- `POST /api_hapus_barang.php` - Hapus barang (JSON)

### Reservasi
- `POST /api_simpan_reservasi.php` - Buat reservasi baru
- `GET /api_detail_reservasi.php` - List semua reservasi
- `GET /api_detail_reservasi.php?id={id}` - Detail reservasi
- `GET /api_riwayat_user.php?username={username}` - Riwayat user
- `POST /api_update_status.php` - Update status reservasi (JSON)
- `GET /api_kalender_reservasi.php?id_barang={id}` - Kalender reservasi

### Profil Masjid
- `GET /api_landing_content.php` - Data landing (profil, berita, acara, layanan)
- `GET /api_struktur.php` - Struktur organisasi
- `POST /api_edit_profil_masjid.php` - Edit profil (multipart)
- `POST /api_edit_struktur.php` - Edit struktur (multipart)

### Profil User
- `GET /api_get_profile.php?username={username}` - Data profil user
- `POST /api_update_profile_user.php` - Update profil (multipart)
- `POST /api_request_otp_profile.php` - Request OTP ganti password
- `POST /api_update_password.php` - Update password

### Notifikasi
- `GET /api_notifikasi_web.php?username={username}&role={role}` - List notifikasi

---

## 📁 Struktur Proyek

```
masjid-nurul-huda/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Login, Register, OTP
│   │   │   ├── BeritaController.php
│   │   │   ├── EventController.php
│   │   │   ├── PersewaanController.php
│   │   │   ├── ReservasiController.php
│   │   │   ├── ProfilMasjidController.php
│   │   │   ├── NotifikasiController.php
│   │   │   └── ProfileUserController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── UserMiddleware.php
│   └── Services/
│       └── ApiService.php      # ⭐ HTTP Client untuk API eksternal
├── resources/views/
│   ├── layouts/                # app.blade.php, navbar, footer
│   ├── auth/                   # login, register, verifikasi, lupa-password
│   ├── home.blade.php          # Landing page
│   ├── berita/                 # index, show, create, edit
│   ├── event/                  # index, show, create, edit
│   ├── reservasi/              # index, detail-barang, status
│   ├── profil-masjid/          # show, struktur
│   ├── profil-user/            # show
│   ├── notifikasi/             # index
│   └── admin/                  # Semua halaman admin
├── routes/
│   └── web.php                 # 57 routes
├── .env                        # Konfigurasi (API_BASE_URL)
└── README.md
```

---

## 🔐 Autentikasi & Session

- **Tidak menggunakan Laravel Auth Guard** (karena tidak ada database lokal)
- **Session-based authentication** menggunakan `Session::put('user', [...])`
- Data user disimpan di session setelah login berhasil via API
- Middleware `AdminMiddleware` dan `UserMiddleware` mengecek session

---

## 🛠️ Teknologi

- **Backend:** Laravel 11 (Frontend Framework)
- **API:** PHP Native (Backend Eksternal)
- **Frontend:** Bootstrap 5.3, Bootstrap Icons, AOS Animation
- **Database:** MySQL (Remote, via API)
- **Auth:** Session-based (custom)
- **HTTP Client:** Laravel HTTP Client (Guzzle)
- **Kalender:** FullCalendar 6
- **Notifikasi:** SweetAlert2

---

## 📝 Keunggulan Arsitektur Ini

✅ **Separation of Concerns** — Frontend dan backend terpisah  
✅ **Scalable** — Backend API bisa digunakan oleh mobile app, desktop app, dll  
✅ **No Database Migration** — Langsung pakai database yang sudah ada  
✅ **Backward Compatible** — PHP native tetap bisa diakses langsung  
✅ **Modern UI** — Laravel Blade dengan Bootstrap 5  
✅ **Easy Deployment** — Tidak perlu setup database di server frontend  

---

## 🚦 Cara Menjalankan

```bash
# Development
php artisan serve

# Akses di browser
http://localhost:8000
```

### Login dengan Akun yang Sudah Ada

Gunakan akun yang sudah terdaftar di database remote (via API):

| Role | Username | Password |
|------|----------|----------|
| Admin | (sesuai database) | (sesuai database) |
| User | (sesuai database) | (sesuai database) |

---

## 🔧 Troubleshooting

### API tidak bisa diakses
- Pastikan `API_BASE_URL` di `.env` benar
- Cek koneksi internet
- Pastikan API server aktif

### Error "Class ApiService not found"
```bash
composer dump-autoload
```

### Session tidak tersimpan
- Pastikan `SESSION_DRIVER=file` di `.env`
- Jalankan `php artisan config:clear`

---

## 📞 Kontak

Untuk pertanyaan atau bantuan, hubungi tim pengembang Masjid Nurul Huda.

---

**Dibuat dengan ❤️ menggunakan Laravel 11**
#   M a s _ N u r _ v 2  
 