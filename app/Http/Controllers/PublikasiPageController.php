<?php

namespace App\Http\Controllers;

use App\Models\ProfilMasjid;
use App\Models\Publikasi;

class PublikasiPageController extends Controller
{
    /**
     * Halaman website publikasi terpisah — hanya tampilkan poster aktif.
     */
    public function index()
    {
        $posters = Publikasi::active()->orderBy('created_at', 'desc')->get();
        $profil  = ProfilMasjid::first();

        return view('publikasi.index', compact('posters', 'profil'));
    }
}
