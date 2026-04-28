<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Akun;
use App\Models\ProfilMasjid;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        Akun::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama'      => 'Administrator',
                'email'     => 'admin@masjidnurulhuda.com',
                'password'  => Hash::make('Admin123'),
                'no_telpon' => '08123456789',
                'role'      => 'admin',
                'status'    => 'aktif',
            ]
        );

        // Profil masjid default
        ProfilMasjid::firstOrCreate(
            ['id' => 1],
            [
                'nama_masjid'    => 'Masjid Nurul Huda',
                'deskripsi'      => 'Sistem digital untuk memakmurkan masjid dan mempererat ukhuwah islamiyah.',
                'sejarah_masjid' => 'Masjid Nurul Huda berdiri sebagai pusat kegiatan keagamaan dan sosial masyarakat.',
                'alamat'         => 'Nganjuk, Jawa Timur',
                'telepon'        => '-',
                'email'          => 'info@masjidnurulhuda.com',
            ]
        );

        $this->command->info('✅ Seeder berhasil! Admin: username=admin, password=Admin123');
    }
}
