<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'username' => 'testing',
            'password' => Hash::make('password'),
            'nama' => 'Romli',
            'telp' => '085334',
            'alamat' => 'Solo',
            'role' => 'PETUGAS'
        ];

        Users::create($data);
    }
}
