<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Super Admin',
            'code'     => 'ADMIN001',
            'email'    => 'admin@tadarus.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'status'   => true,
        ]);
        Profile::create([
            'user_id'  => $admin->id,
            'nomor_hp' => '081234567890',
            'alamat'   => 'Kantor Pusat',
        ]);

        $guru = User::create([
            'name'     => 'Ustadz Ahmad',
            'email'    => 'guru@tadarus.test',
            'password' => Hash::make('password'),
            'role'     => 'guru',
            'status'   => true,
        ]);
        Profile::create([
            'user_id'  => $guru->id,
            'nomor_hp' => '082345678901',
            'alamat'   => 'Jl. Masjid No. 1',
        ]);

        $peserta = User::create([
            'name'     => 'Santri Budi',
            'email'    => 'peserta@tadarus.test',
            'password' => Hash::make('password'),
            'role'     => 'peserta',
            'status'   => true,
        ]);
        Profile::create([
            'user_id'  => $peserta->id,
            'nomor_hp' => '083456789012',
            'alamat'   => 'Jl. Pondok No. 5',
        ]);
    }
}