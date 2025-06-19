<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin SMK 1 Mendo Barat',
            'email' => 'admin@smk1mendobarat.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => '1',
            'email_verified_at' => now(),
        ]);

        // Instructor User
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smk1mendobarat.sch.id',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'status' => '1',
            'email_verified_at' => now(),
        ]);

        // Regular User
        User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@smk1mendobarat.sch.id',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => '1',
            'email_verified_at' => now(),
        ]);

        // Generate additional users using factory
        User::factory(10)->create();
    }
}
