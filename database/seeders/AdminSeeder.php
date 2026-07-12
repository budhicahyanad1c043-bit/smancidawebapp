<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::updateOrCreate(
            ['username' => 'admin'], // Kunci pencarian berdasarkan username
            [
                'name' => 'Dianan Maisha',
                'email' => 'dinanmaisharafani@gmail.com',
                'password' => Hash::make('D1c00043*'), // sesuaikan passwordnya
                'role' => 'admin',
            ]
        );
    }
}
