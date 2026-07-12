<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Memanggil seeder Admin yang sudah kita buat sebelumnya
        $this->call(AdminSeeder::class);

        \App\Models\Setting::create([
            'school_name' => 'SMAN 1 Cidahu',
            'logo' => 'images/logo.png', 
            'principal_name' => 'Nama Kepala Sekolah, M.Pd.',
        ]);
    }
}
