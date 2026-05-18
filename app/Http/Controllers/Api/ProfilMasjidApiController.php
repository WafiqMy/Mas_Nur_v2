<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilMasjid;
use Illuminate\Http\JsonResponse;

class ProfilMasjidApiController extends Controller
{
    public function index(): JsonResponse
    {
        $profil = ProfilMasjid::first();

        if (!$profil) {
            return response()->json(['status' => 'success', 'data' => null]);
        }

        return response()->json(['status' => 'success', 'data' => [
            'nama_masjid'            => $profil->nama_masjid,
            'deskripsi'              => $profil->deskripsi,
            'sejarah_masjid'         => $profil->sejarah_masjid,
            'alamat'                 => $profil->alamat,
            'telepon'                => $profil->telepon,
            'email'                  => $profil->email,
            'website'                => $profil->website,
            'gambar_sampul_url'      => $profil->gambar_sampul_url,
            'gambar_sejarah_url'     => $profil->gambar_sejarah_url,
        ]]);
    }

    public function struktur(): JsonResponse
    {
        $profil = ProfilMasjid::first();

        return response()->json(['status' => 'success', 'data' => [
            'gambar_struktur_organisasi_url' => $profil?->gambar_sampul_url ?? null,
            'gambar_struktur_remas_url'      => $profil?->gambar_struktur_url ?? null,
            'deskripsi_remas'                => $profil?->deskripsi_remas ?? '',
        ]]);
    }
}
