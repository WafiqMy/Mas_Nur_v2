<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Event;
use App\Models\FoodCourt;
use App\Models\ProfilMasjid;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::orderBy('tanggal_berita', 'desc')->limit(3)->get();
        $acara  = Event::orderBy('tanggal_event', 'desc')->limit(3)->get();

        return view('home', compact('berita', 'acara'));
    }
}
