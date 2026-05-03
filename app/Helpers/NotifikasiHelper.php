<?php

namespace App\Helpers;

/**
 * Helper untuk generate dan manage notifikasi link
 * Konversi link dari format lama ke format Laravel routing baru
 */
class NotifikasiHelper
{
    /**
     * Generate link untuk notifikasi reservasi
     * 
     * @param int $id ID reservasi
     * @param string $action Aksi (view, edit, etc)
     * @return string URL yang benar
     */
    public static function generateReservasiLink(int $id, string $action = 'view'): string
    {
        // Format baru: /admin/reservasi/permintaan/{id}
        return route('admin.reservasi.detail-permintaan', ['id' => $id]);
    }

    /**
     * Convert link format lama ke format baru
     * 
     * @param string|null $oldLink Link dalam format lama
     * @param array $params Parameter tambahan
     * @return string URL yang benar atau # jika invalid
     */
    public static function convertLegacyLink(?string $oldLink, array $params = []): string
    {
        if (!$oldLink) {
            return '#';
        }

        // Jika sudah format baru, kembalikan apa adanya
        if (str_starts_with($oldLink, 'http') || str_starts_with($oldLink, '/admin/')) {
            return $oldLink;
        }

        // Parse format lama: detail_permintaan.php?id=43
        if (str_contains($oldLink, 'detail_permintaan')) {
            // Extract ID dari query string atau params
            if (preg_match('/id[=\:](\d+)/', $oldLink, $matches)) {
                return self::generateReservasiLink((int)$matches[1]);
            }
        }

        // Default fallback
        return '/' . ltrim($oldLink, '/');
    }

    /**
     * Get pesan notifikasi untuk reservasi
     * 
     * @param string $userName Nama pengguna
     * @param string $itemName Nama barang
     * @param string $status Status (Menunggu, Disetujui, Ditolak)
     * @return string Pesan HTML
     */
    public static function getReservasiMessage(string $userName, string $itemName, string $status): string
    {
        $statusLower = strtolower($status);

        return match ($statusLower) {
            'menunggu' => "Permintaan reservasi <strong>$itemName</strong> dari user <strong>$userName</strong> sedang menunggu persetujuan.",
            'disetujui' => "Permintaan reservasi <strong>$itemName</strong> dari user <strong>$userName</strong> telah <strong style='color: green;'>disetujui</strong>.",
            'ditolak' => "Permintaan reservasi <strong>$itemName</strong> dari user <strong>$userName</strong> telah <strong style='color: red;'>ditolak</strong>.",
            default => "Status reservasi <strong>$itemName</strong> dari user <strong>$userName</strong> berubah menjadi <strong>$status</strong>.",
        };
    }

    /**
     * Get judul notifikasi untuk reservasi
     * 
     * @param string $status Status reservasi
     * @return string Judul notifikasi
     */
    public static function getReservasiTitle(string $status): string
    {
        $statusLower = strtolower($status);

        return match ($statusLower) {
            'menunggu' => 'Permintaan Reservasi Baru',
            'disetujui' => 'Permintaan Reservasi Disetujui ✅',
            'ditolak' => 'Permintaan Reservasi Ditolak ❌',
            default => "Status Reservasi: $status",
        };
    }

    /**
     * Get badge class untuk status
     * 
     * @param string $status Status
     * @return string CSS class
     */
    public static function getBadgeClass(string $status): string
    {
        $statusLower = strtolower($status);

        return match ($statusLower) {
            'menunggu' => 'bg-warning text-dark',
            'disetujui' => 'bg-success text-white',
            'ditolak' => 'bg-danger text-white',
            'batal' => 'bg-secondary text-white',
            default => 'bg-info text-white',
        };
    }
}
