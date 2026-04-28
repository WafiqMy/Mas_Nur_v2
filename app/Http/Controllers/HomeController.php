<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class HomeController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $raw = $this->api->getLandingContent();

        $profil  = $raw['profil']  ?? null;
        $berita  = $raw['berita']  ?? [];
        $acara   = $raw['acara']   ?? [];
        $layanan = $raw['layanan'] ?? null;

        return view('home', compact('profil', 'berita', 'acara', 'layanan'));
    }
}
