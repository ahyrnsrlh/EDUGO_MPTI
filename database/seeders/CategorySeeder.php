<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Teknik Komputer dan Jaringan (TKJ)',
                'slug' => 'teknik-komputer-dan-jaringan',
                'image' => 'tkj.jpg',
                'subcategories' => [
                    'Instalasi Sistem Operasi',
                    'Administrasi Server',
                    'Konfigurasi Jaringan',
                    'Keamanan Jaringan',
                    'Troubleshooting Hardware',
                    'Maintenance Komputer'
                ]
            ],
            [
                'name' => 'Teknik Kendaraan Ringan Otomotif (TKRO)',
                'slug' => 'teknik-kendaraan-ringan-otomotif',
                'image' => 'tkro.jpg',
                'subcategories' => [
                    'Sistem Kelistrikan Otomotif',
                    'Sistem Mesin Bensin',
                    'Sistem Transmisi',
                    'Sistem Rem dan Kemudi',
                    'Engine Tune Up',
                    'Diagnosa Kerusakan Kendaraan'
                ]
            ],
            [
                'name' => 'Akuntansi dan Keuangan Lembaga (AKL)',
                'slug' => 'akuntansi-dan-keuangan-lembaga',
                'image' => 'akl.jpg',
                'subcategories' => [
                    'Dasar-dasar Akuntansi',
                    'Administrasi Keuangan',
                    'Komputer Akuntansi',
                    'Perpajakan',
                    'Manajemen Kas',
                    'Laporan Keuangan'
                ]
            ],
            [
                'name' => 'Bisnis Daring dan Pemasaran (BDP)',
                'slug' => 'bisnis-daring-dan-pemasaran',
                'image' => 'bdp.jpg',
                'subcategories' => [
                    'E-Commerce',
                    'Digital Marketing',
                    'Social Media Marketing',
                    'Fotografi Produk',
                    'Manajemen Toko Online',
                    'Customer Service Online'
                ]
            ],
            [
                'name' => 'Mata Pelajaran Umum',
                'slug' => 'mata-pelajaran-umum',
                'image' => 'umum.jpg',
                'subcategories' => [
                    'Bahasa Indonesia',
                    'Bahasa Inggris',
                    'Matematika',
                    'Sejarah Indonesia',
                    'Pendidikan Pancasila dan Kewarganegaraan',
                    'Pendidikan Agama dan Budi Pekerti'
                ]
            ],
            [
                'name' => 'Praktik Kerja Lapangan (PKL)',
                'slug' => 'praktik-kerja-lapangan',
                'image' => 'pkl.jpg',
                'subcategories' => [
                    'Persiapan PKL',
                    'Laporan PKL',
                    'Presentasi PKL',
                    'Evaluasi PKL'
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'image' => $categoryData['image'],
            ]);

            foreach ($categoryData['subcategories'] as $subCategoryName) {
                SubCategory::create([
                    'name' => $subCategoryName,
                    'slug' => Str::slug($subCategoryName),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
