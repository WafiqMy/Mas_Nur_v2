<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.api_base_url', 'https://masnurhudanganjuk.pbltifnganjuk.com/API');
    }

    // ===================== HELPER =====================

    protected function get(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::timeout(15)
                ->withoutVerifying()
                ->get($this->baseUrl . $endpoint, $params);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error("API GET Error [{$endpoint}]: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menghubungi server.'];
        }
    }

    protected function post(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout(15)
                ->withoutVerifying()
                ->post($this->baseUrl . $endpoint, $data);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error("API POST Error [{$endpoint}]: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menghubungi server.'];
        }
    }

    protected function postJson(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout(15)
                ->withoutVerifying()
                ->asJson()
                ->post($this->baseUrl . $endpoint, $data);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error("API POST JSON Error [{$endpoint}]: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menghubungi server.'];
        }
    }

    protected function postMultipart(string $endpoint, array $fields = [], array $files = []): array
    {
        try {
            $request = Http::timeout(30)->withoutVerifying()->asMultipart();

            foreach ($files as $name => $file) {
                if ($file) {
                    $request = $request->attach(
                        $name,
                        file_get_contents($file->getRealPath()),
                        $file->getClientOriginalName()
                    );
                }
            }

            $response = $request->post($this->baseUrl . $endpoint, $fields);

            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error("API Multipart Error [{$endpoint}]: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menghubungi server.'];
        }
    }

    // ===================== AUTH =====================

    public function login(string $username, string $password): array
    {
        return $this->postJson('/api_login_web.php', [
            'username' => $username,
            'password' => $password,
        ]);
    }

    public function register(array $data): array
    {
        return $this->postJson('/api_register.php', $data);
    }

    public function verifikasi(string $email, string $otp): array
    {
        return $this->postJson('/api_verifikasi.php', [
            'email' => $email,
            'otp'   => $otp,
        ]);
    }

    public function lupaPasswordRequest(string $email): array
    {
        return $this->postJson('/api_lupa_request.php', ['email' => $email]);
    }

    public function lupaPasswordVerify(string $email, string $otp): array
    {
        return $this->postJson('/api_lupa_verify.php', ['email' => $email, 'otp' => $otp]);
    }

    public function lupaPasswordReset(string $email, string $otp, string $password): array
    {
        return $this->postJson('/api_lupa_reset.php', [
            'email'    => $email,
            'otp'      => $otp,
            'password' => $password,
        ]);
    }

    // ===================== LANDING =====================

    public function getLandingContent(): array
    {
        return $this->get('/api_landing_content.php');
    }

    // ===================== BERITA =====================

    public function getBeritaList(): array
    {
        return $this->get('/berita-list.php');
    }

    public function getBerita(int $id): array
    {
        return $this->get('/api_get_berita.php', ['id' => $id]);
    }

    public function tambahBerita(array $fields, $foto = null): array
    {
        $files = $foto ? ['foto_berita' => $foto] : [];
        return $this->postMultipart('/api_tambah_berita.php', $fields, $files);
    }

    public function editBerita(array $fields, $foto = null): array
    {
        $files = $foto ? ['foto_berita' => $foto] : [];
        return $this->postMultipart('/api_edit_berita.php', $fields, $files);
    }

    public function hapusBerita(int $id): array
    {
        return $this->get('/api_hapus_berita.php', ['id_berita' => $id]);
    }

    // ===================== EVENT / ACARA =====================

    public function getEventList(): array
    {
        return $this->get('/api_get_event.php');
    }

    public function getEvent(int $id): array
    {
        return $this->get('/api_get_event.php', ['id' => $id]);
    }

    public function tambahEvent(array $fields, $gambar = null, array $dokumentasi = []): array
    {
        try {
            $request = Http::timeout(30)->withoutVerifying()->asMultipart();

            if ($gambar) {
                $request = $request->attach(
                    'gambar_event',
                    file_get_contents($gambar->getRealPath()),
                    $gambar->getClientOriginalName()
                );
            }

            foreach ($dokumentasi as $i => $dok) {
                $request = $request->attach(
                    "dokumentasi[{$i}]",
                    file_get_contents($dok->getRealPath()),
                    $dok->getClientOriginalName()
                );
            }

            $response = $request->post($this->baseUrl . '/api_tambah_event.php', $fields);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            Log::error('tambahEvent error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menghubungi server.'];
        }
    }

    public function editEvent(array $fields, $gambar = null): array
    {
        $files = $gambar ? ['gambar_event' => $gambar] : [];
        return $this->postMultipart('/api_edit_event.php', $fields, $files);
    }

    public function hapusEvent(int $id): array
    {
        return $this->postJson('/api_hapus_event.php', ['id_event' => $id]);
    }

    // ===================== PERSEWAAN / BARANG =====================

    public function getBarangList(?string $jenis = null): array
    {
        $params = $jenis ? ['jenis' => $jenis] : [];
        return $this->get('/api_barang.php', $params);
    }

    public function tambahBarang(array $fields, $gambar = null): array
    {
        $files = $gambar ? ['gambar' => $gambar] : [];
        return $this->postMultipart('/api_tambah_barang.php', $fields, $files);
    }

    public function editBarang(array $fields, $gambar = null): array
    {
        $files = $gambar ? ['gambar' => $gambar] : [];
        return $this->postMultipart('/api_edit_barang.php', $fields, $files);
    }

    public function hapusBarang(int $id): array
    {
        return $this->postJson('/api_hapus_barang.php', ['id_persewaan' => $id]);
    }

    // ===================== RESERVASI =====================

    public function simpanReservasi(array $data): array
    {
        return $this->post('/api_simpan_reservasi.php', $data);
    }

    public function getDetailReservasi(?int $id = null): array
    {
        $params = $id ? ['id' => $id] : [];
        return $this->get('/api_detail_reservasi.php', $params);
    }

    public function getRiwayatUser(string $username): array
    {
        return $this->get('/api_riwayat_user.php', ['username' => $username]);
    }

    public function updateStatusReservasi(int $id, string $status, ?string $notes = null): array
    {
        return $this->postJson('/api_update_status.php', [
            'id'     => $id,
            'status' => $status,
            'notes'  => $notes,
        ]);
    }

    public function getKalenderReservasi(int $id_barang): array
    {
        return $this->get('/api_kalender_reservasi.php', ['id_barang' => $id_barang]);
    }

    // ===================== PROFIL MASJID =====================

    public function getProfilMasjid(): array
    {
        return $this->get('/api_landing_content.php');
    }

    public function getStruktur(): array
    {
        return $this->get('/api_struktur.php');
    }

    public function editProfilMasjid(array $fields, $gambar = null): array
    {
        $files = $gambar ? ['gambar_sejarah_masjid' => $gambar] : [];
        return $this->postMultipart('/api_edit_profil_masjid.php', $fields, $files);
    }

    public function editStruktur(array $fields, $gambarOrg = null, $gambarRemas = null): array
    {
        $files = [];
        if ($gambarOrg) $files['gambar_struktur_organisasi'] = $gambarOrg;
        if ($gambarRemas) $files['gambar_struktur_remas'] = $gambarRemas;
        return $this->postMultipart('/api_edit_struktur.php', $fields, $files);
    }

    // ===================== PROFIL USER =====================

    public function getProfilUser(string $username): array
    {
        return $this->get('/api_get_profile.php', ['username' => $username]);
    }

    public function updateProfilUser(array $fields, $gambar = null): array
    {
        $files = $gambar ? ['file_gambar' => $gambar] : [];
        return $this->postMultipart('/api_update_profile_user.php', $fields, $files);
    }

    public function requestOtpProfile(string $username): array
    {
        return $this->post('/api_request_otp_profile.php', ['username' => $username]);
    }

    public function updatePassword(string $username, string $otp, string $passwordBaru): array
    {
        return $this->post('/api_update_password.php', [
            'username'      => $username,
            'otp'           => $otp,
            'password_baru' => $passwordBaru,
        ]);
    }

    // ===================== NOTIFIKASI =====================

    public function getNotifikasi(string $username, string $role): array
    {
        return $this->get('/api_notifikasi_web.php', [
            'username' => $username,
            'role'     => $role,
        ]);
    }
}
