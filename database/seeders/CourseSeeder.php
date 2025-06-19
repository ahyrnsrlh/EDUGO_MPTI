<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\CourseGoal;
use Faker\Factory as Faker;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $instructors = User::where('role', 'instructor')->get();
        $categories = Category::all();
        
        $courses = [
            // TKJ Courses
            [
                'course_name' => 'Instalasi dan Konfigurasi Sistem Operasi Windows',
                'course_title' => 'Panduan Lengkap Instalasi Windows untuk SMK TKJ',
                'description' => 'Pelajari cara instalasi, konfigurasi, dan maintenance sistem operasi Windows untuk kebutuhan administrasi jaringan',
                'video' => 'windows-installation.mp4',
                'course_image' => 'windows-course.jpg',
                'selling_price' => 299000,
                'discount_price' => 199000,
                'duration' => '20 jam',
                'resources' => '50+ materi pembelajaran dan praktikum',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Teknik Komputer dan Jaringan (TKJ)'
            ],
            [
                'course_name' => 'Dasar-dasar Jaringan Komputer',
                'course_title' => 'Memahami Konsep Jaringan dan Protokol TCP/IP',
                'description' => 'Pelajari fundamental jaringan komputer, subnetting, routing, dan switching untuk siswa TKJ',
                'video' => 'networking-basics.mp4',
                'course_image' => 'networking-course.jpg',
                'selling_price' => 349000,
                'discount_price' => 249000,
                'duration' => '25 jam',
                'resources' => '60+ simulasi dan lab virtual',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Teknik Komputer dan Jaringan (TKJ)'
            ],

            // TKRO Courses
            [
                'course_name' => 'Sistem Kelistrikan Otomotif',
                'course_title' => 'Memahami Rangkaian Kelistrikan Kendaraan',
                'description' => 'Pelajari sistem kelistrikan otomotif dari dasar hingga troubleshooting untuk siswa TKRO',
                'video' => 'automotive-electrical.mp4',
                'course_image' => 'automotive-electrical.jpg',
                'selling_price' => 399000,
                'discount_price' => 299000,
                'duration' => '30 jam',
                'resources' => '40+ diagram dan simulasi',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Teknik Kendaraan Ringan Otomotif (TKRO)'
            ],
            [
                'course_name' => 'Engine Tune Up dan Maintenance',
                'course_title' => 'Perawatan dan Penyetelan Mesin Kendaraan',
                'description' => 'Pelajari teknik tune up mesin, perawatan berkala, dan diagnosa kerusakan mesin kendaraan',
                'video' => 'engine-tuneup.mp4',
                'course_image' => 'engine-tuneup.jpg',
                'selling_price' => 449000,
                'discount_price' => 329000,
                'duration' => '35 jam',
                'resources' => '70+ video praktik dan manual',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 0,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Teknik Kendaraan Ringan Otomotif (TKRO)'
            ],

            // AKL Courses
            [
                'course_name' => 'Dasar-dasar Akuntansi Perusahaan',
                'course_title' => 'Memahami Siklus Akuntansi dan Laporan Keuangan',
                'description' => 'Pelajari konsep dasar akuntansi, jurnal, posting, dan pembuatan laporan keuangan sederhana',
                'video' => 'basic-accounting.mp4',
                'course_image' => 'accounting-course.jpg',
                'selling_price' => 329000,
                'discount_price' => 229000,
                'duration' => '28 jam',
                'resources' => '80+ contoh kasus dan latihan',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Akuntansi dan Keuangan Lembaga (AKL)'
            ],
            [
                'course_name' => 'Aplikasi Komputer Akuntansi',
                'course_title' => 'Menggunakan Software Akuntansi untuk UKM',
                'description' => 'Pelajari penggunaan software akuntansi modern untuk mengelola keuangan usaha kecil menengah',
                'video' => 'accounting-software.mp4',
                'course_image' => 'accounting-software.jpg',
                'selling_price' => 279000,
                'discount_price' => 189000,
                'duration' => '22 jam',
                'resources' => '50+ template dan praktikum',
                'certificate' => 'ya',
                'bestseller' => 0,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Akuntansi dan Keuangan Lembaga (AKL)'
            ],

            // BDP Courses
            [
                'course_name' => 'Digital Marketing untuk UMKM',
                'course_title' => 'Strategi Pemasaran Online yang Efektif',
                'description' => 'Pelajari teknik digital marketing, social media marketing, dan strategi promosi online untuk UMKM',
                'video' => 'digital-marketing.mp4',
                'course_image' => 'digital-marketing.jpg',
                'selling_price' => 369000,
                'discount_price' => 259000,
                'duration' => '26 jam',
                'resources' => '60+ template dan case study',
                'certificate' => 'ya',
                'bestseller' => 1,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Bisnis Daring dan Pemasaran (BDP)'
            ],
            [
                'course_name' => 'Manajemen Toko Online (E-Commerce)',
                'course_title' => 'Membangun dan Mengelola Toko Online',
                'description' => 'Pelajari cara membuat, mengelola, dan mengoptimalkan toko online menggunakan platform e-commerce',
                'video' => 'ecommerce-management.mp4',
                'course_image' => 'ecommerce-course.jpg',
                'selling_price' => 319000,
                'discount_price' => 219000,
                'duration' => '24 jam',
                'resources' => '45+ panduan dan tools',
                'certificate' => 'ya',
                'bestseller' => 0,
                'featured' => 1,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Bisnis Daring dan Pemasaran (BDP)'
            ],

            // Mata Pelajaran Umum
            [
                'course_name' => 'Bahasa Inggris untuk Komunikasi Bisnis',
                'course_title' => 'English for Business Communication',
                'description' => 'Pelajari bahasa Inggris yang digunakan dalam dunia kerja dan komunikasi bisnis',
                'video' => 'business-english.mp4',
                'course_image' => 'business-english.jpg',
                'selling_price' => 249000,
                'discount_price' => 179000,
                'duration' => '18 jam',
                'resources' => '30+ audio dan conversation practice',
                'certificate' => 'ya',
                'bestseller' => 0,
                'featured' => 0,
                'highestrated' => 1,
                'status' => 1,
                'category_name' => 'Mata Pelajaran Umum'
            ],
            [
                'course_name' => 'Matematika Terapan untuk SMK',
                'course_title' => 'Matematika Praktis untuk Dunia Kerja',
                'description' => 'Pelajari aplikasi matematika dalam kehidupan sehari-hari dan dunia kerja',
                'video' => 'applied-math.mp4',
                'course_image' => 'applied-math.jpg',
                'selling_price' => 229000,
                'discount_price' => 169000,
                'duration' => '20 jam',
                'resources' => '40+ contoh soal dan aplikasi',
                'certificate' => 'ya',
                'bestseller' => 0,
                'featured' => 0,
                'highestrated' => 0,
                'status' => 1,
                'category_name' => 'Mata Pelajaran Umum'
            ]
        ];

        foreach ($courses as $courseData) {
            // Find category by name
            $category = Category::where('name', $courseData['category_name'])->first();
            if (!$category) {
                $category = $categories->first(); // fallback to first category
            }
            
            // Get random subcategory from this category
            $subcategory = SubCategory::where('category_id', $category->id)->inRandomOrder()->first();
            
            $course = Course::create([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory ? $subcategory->id : null,
                'instructor_id' => $instructors->random()->id,
                'course_name' => $courseData['course_name'],
                'course_name_slug' => Str::slug($courseData['course_name']),
                'course_title' => $courseData['course_title'],
                'description' => $courseData['description'],
                'video_url' => $courseData['video'],
                'course_image' => $courseData['course_image'],
                'selling_price' => $courseData['selling_price'],
                'discount_price' => $courseData['discount_price'],
                'duration' => (float) str_replace(' jam', '', $courseData['duration']),
                'resources' => $courseData['resources'],
                'certificate' => $courseData['certificate'],
                'bestseller' => (string) $courseData['bestseller'],
                'featured' => (string) $courseData['featured'],
                'highestrated' => (string) $courseData['highestrated'],
                'status' => $courseData['status'],
            ]);

            // Add course goals based on category
            $goals = [];
            
            if (str_contains($courseData['category_name'], 'TKJ')) {
                $goals = [
                    'Memahami konsep dasar teknologi komputer dan jaringan',
                    'Mampu menginstalasi dan mengkonfigurasi sistem',
                    'Menguasai troubleshooting hardware dan software',
                    'Memahami administrasi jaringan dan server',
                    'Siap untuk sertifikasi kompetensi TKJ'
                ];
            } elseif (str_contains($courseData['category_name'], 'TKRO')) {
                $goals = [
                    'Memahami sistem kerja kendaraan bermotor',
                    'Mampu melakukan diagnosa kerusakan kendaraan',
                    'Menguasai teknik perawatan dan perbaikan',
                    'Memahami sistem kelistrikan otomotif',
                    'Siap bekerja di bengkel atau industri otomotif'
                ];
            } elseif (str_contains($courseData['category_name'], 'AKL')) {
                $goals = [
                    'Memahami prinsip dasar akuntansi',
                    'Mampu membuat laporan keuangan sederhana',
                    'Menguasai aplikasi software akuntansi',
                    'Memahami perpajakan dan administrasi keuangan',
                    'Siap bekerja di bidang keuangan dan akuntansi'
                ];
            } elseif (str_contains($courseData['category_name'], 'BDP')) {
                $goals = [
                    'Memahami konsep bisnis digital dan e-commerce',
                    'Mampu mengelola toko online',
                    'Menguasai strategi digital marketing',
                    'Memahami customer service online',
                    'Siap membuka usaha online atau bekerja di bidang digital marketing'
                ];
            } else {
                $goals = [
                    'Memahami materi pembelajaran dengan baik',
                    'Mampu mengaplikasikan ilmu dalam kehidupan sehari-hari',
                    'Meningkatkan kemampuan akademis',
                    'Mempersiapkan diri untuk dunia kerja',
                    'Mencapai standar kompetensi yang ditetapkan'
                ];
            }

            foreach ($goals as $goal) {
                CourseGoal::create([
                    'course_id' => $course->id,
                    'goal_name' => $goal,
                ]);
            }
        }
    }
}
