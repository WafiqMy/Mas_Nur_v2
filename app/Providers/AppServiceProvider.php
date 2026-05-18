<?php

namespace App\Providers;

use App\Models\ProfilMasjid;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share $waUrl ke semua view — cache per request agar tidak query DB berkali-kali
        View::composer('*', function ($view) {
            static $cached = false;
            static $waUrl  = '#';

            if (!$cached) {
                try {
                    $profil = ProfilMasjid::select('whatsapp')->first();
                    $nomor  = $profil?->whatsapp;

                    if ($nomor) {
                        $nomor = preg_replace('/[^0-9]/', '', $nomor);
                        if (str_starts_with($nomor, '0')) {
                            $nomor = '62' . substr($nomor, 1);
                        }
                        $waUrl = 'https://wa.me/' . $nomor;
                    } else {
                        $waUrl = config('masjid.sosial.whatsapp', '#');
                    }
                } catch (\Throwable $e) {
                    $waUrl = config('masjid.sosial.whatsapp', '#');
                }
                $cached = true;
            }

            $view->with('waUrl', $waUrl);
        });

        // Share $profil ke layout publikasi
        View::composer('layouts.publikasi', function ($view) {
            try {
                $view->with('profil', ProfilMasjid::first());
            } catch (\Throwable $e) {
                $view->with('profil', null);
            }
        });
    }
}
