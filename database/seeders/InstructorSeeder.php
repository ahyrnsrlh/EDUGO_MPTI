<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'Bapak Andi Pratama, S.Kom',
                'email' => 'andi.pratama@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru TKJ dengan pengalaman 8 tahun mengajar networking dan sistem operasi. Bersertifikat Cisco CCNA dan Microsoft Certified.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bapak Rizki Firmansyah, S.T',
                'email' => 'rizki.firmansyah@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru TKRO dengan pengalaman 10 tahun di bidang otomotif. Mantan teknisi senior di bengkel resmi dan instruktur LSP Otomotif.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ibu Sari Indrawati, S.E',
                'email' => 'sari.indrawati@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru AKL dengan pengalaman 7 tahun mengajar akuntansi dan keuangan. Praktisi akuntansi dengan sertifikat profesi akuntan.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ibu Maya Sari, S.Pd',
                'email' => 'maya.sari@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru BDP dengan keahlian digital marketing dan e-commerce. Berpengalaman membangun bisnis online dan konsultan UMKM.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bapak Dedi Hermawan, S.Pd',
                'email' => 'dedi.hermawan@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru Bahasa Inggris dengan pengalaman 12 tahun. Spesialis English for Business Communication dan persiapan sertifikasi TOEIC.',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ibu Ratna Dewi, S.Pd',
                'email' => 'ratna.dewi@smk1mendobarat.sch.id',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'status' => '1',
                'bio' => 'Guru Matematika dengan pengalaman 9 tahun mengajar matematika terapan untuk SMK. Ahli dalam aplikasi matematika untuk dunia kerja.',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($instructors as $instructor) {
            User::create($instructor);
        }
    }
}
