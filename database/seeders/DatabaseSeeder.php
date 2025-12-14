<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lab;
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
        // Seed a lab first if it doesn't exist
        if (!Lab::where('kode_lab', 'SJ001')->exists()) {
            Lab::create([
                'nama_lab' => 'SISJAR Lab',
                'kode_lab' => 'SJ001',
            ]);
        }

        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'nama_lengkap' => 'Test User',
                'kode_aslab' => 'TEST001',
                'email' => 'test@example.com',
                'username' => 'testuser',
                'id_lab' => 1,
                'jurusan' => 'Sistem Informasi',
                'role' => 'admin',
            ]);
        }
    }
}
