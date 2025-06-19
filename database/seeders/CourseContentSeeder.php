<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseContents = [
            // TKJ Courses
            'Instalasi dan Konfigurasi Sistem Operasi Windows' => [                [
                    'section_name' => 'Pengenalan Sistem Operasi',
                    'lectures' => [
                        [
                            'lecture_title' => 'Apa itu Sistem Operasi?',
                            'video_url' => 'https://www.youtube.com/watch?v=26QPDBe-NB8',
                            'url' => 'https://www.youtube.com/embed/26QPDBe-NB8',
                            'content' => 'Pengenalan dasar tentang sistem operasi dan fungsinya dalam komputer',
                        ],
                        [
                            'lecture_title' => 'Sejarah dan Perkembangan Windows',
                            'video_url' => 'https://www.youtube.com/watch?v=tGvHNNOLnCk',
                            'url' => 'https://www.youtube.com/embed/tGvHNNOLnCk',
                            'content' => 'Sejarah dan evolusi sistem operasi Windows dari masa ke masa',
                        ],
                        [
                            'lecture_title' => 'Perbedaan Versi Windows',
                            'video_url' => 'https://www.youtube.com/watch?v=yivyZMWMYPQ',
                            'url' => 'https://www.youtube.com/embed/yivyZMWMYPQ',
                            'content' => 'Memahami perbedaan antara berbagai versi Windows dan kegunaannya',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Instalasi Windows',
                    'lectures' => [
                        [
                            'lecture_title' => 'Persiapan Instalasi Windows',
                            'video_url' => 'https://www.youtube.com/watch?v=SKbR6XT7fcA',
                            'url' => 'https://www.youtube.com/embed/SKbR6XT7fcA',
                            'content' => 'Persiapan hardware dan software sebelum instalasi Windows',
                        ],
                        [
                            'lecture_title' => 'Cara Install Windows 10/11',
                            'video_url' => 'https://www.youtube.com/watch?v=l9GnWYKyyYo',
                            'url' => 'https://www.youtube.com/embed/l9GnWYKyyYo',
                            'content' => 'Tutorial lengkap instalasi Windows 10 dan Windows 11',
                        ],
                        [
                            'lecture_title' => 'Partisi Hard Drive',
                            'video_url' => 'https://www.youtube.com/watch?v=AeUM4kR67XQ',
                            'url' => 'https://www.youtube.com/embed/AeUM4kR67XQ',
                            'content' => 'Cara membuat dan mengelola partisi hard drive',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Konfigurasi Sistem',
                    'lectures' => [
                        [
                            'lecture_title' => 'Konfigurasi Awal Windows',
                            'video_url' => 'https://www.youtube.com/watch?v=ISOdYJpVmYs',
                            'url' => 'https://www.youtube.com/embed/ISOdYJpVmYs',
                            'content' => 'Konfigurasi dasar setelah instalasi Windows selesai',
                        ],
                        [
                            'lecture_title' => 'Install Driver dan Software',
                            'video_url' => 'https://www.youtube.com/watch?v=25DPLmgAx5E',
                            'url' => 'https://www.youtube.com/embed/25DPLmgAx5E',
                            'content' => 'Instalasi driver hardware dan software essential',
                        ]
                    ]
                ]
            ],

            'Dasar-dasar Jaringan Komputer' => [
                [
                    'section_name' => 'Konsep Dasar Jaringan',
                    'lectures' => [
                        [
                            'lecture_title' => 'Pengenalan Jaringan Komputer',
                            'video_url' => 'https://www.youtube.com/watch?v=3QhU9jd03a0',
                            'url' => 'https://www.youtube.com/embed/3QhU9jd03a0',
                            'content' => 'Konsep dasar jaringan komputer dan manfaatnya',
                        ],
                        [
                            'lecture_title' => 'Topologi Jaringan',
                            'video_url' => 'https://www.youtube.com/watch?v=zbqrNg4C98U',
                            'url' => 'https://www.youtube.com/embed/zbqrNg4C98U',
                            'content' => 'Berbagai jenis topologi jaringan dan karakteristiknya',
                        ],
                        [
                            'lecture_title' => 'Model OSI Layer',
                            'video_url' => 'https://www.youtube.com/watch?v=vv4y_uOneC0',
                            'url' => 'https://www.youtube.com/embed/vv4y_uOneC0',
                            'content' => 'Memahami 7 layer OSI dan fungsinya masing-masing',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Protokol TCP/IP',
                    'lectures' => [
                        [
                            'lecture_title' => 'Pengenalan TCP/IP',
                            'video_url' => 'https://www.youtube.com/watch?v=PpsEaqJV_A0',
                            'url' => 'https://www.youtube.com/embed/PpsEaqJV_A0',
                            'content' => 'Dasar-dasar protokol TCP/IP dan cara kerjanya',
                        ],
                        [
                            'lecture_title' => 'IP Address dan Subnetting',
                            'video_url' => 'https://www.youtube.com/watch?v=s_Ntt6eTn94',
                            'url' => 'https://www.youtube.com/embed/s_Ntt6eTn94',
                            'content' => 'Konsep IP Address, subnet mask, dan subnetting',
                        ],
                        [
                            'lecture_title' => 'DHCP dan DNS',
                            'video_url' => 'https://www.youtube.com/watch?v=Rck3BALhI5c',
                            'url' => 'https://www.youtube.com/embed/Rck3BALhI5c',
                            'content' => 'Cara kerja DHCP dan DNS dalam jaringan',
                        ]
                    ]
                ]
            ],

            // TKRO Courses
            'Sistem Kelistrikan Otomotif' => [
                [
                    'section_name' => 'Dasar Kelistrikan Otomotif',
                    'lectures' => [
                        [
                            'lecture_title' => 'Konsep Dasar Listrik',
                            'video_url' => 'https://www.youtube.com/watch?v=1sCPJhaTo2Y',
                            'url' => 'https://www.youtube.com/embed/1sCPJhaTo2Y',
                            'content' => 'Hukum Ohm, arus, tegangan, dan hambatan listrik',
                        ],
                        [
                            'lecture_title' => 'Komponen Kelistrikan Mobil',
                            'video_url' => 'https://www.youtube.com/watch?v=Rs_3erZ7T1o',
                            'url' => 'https://www.youtube.com/embed/Rs_3erZ7T1o',
                            'content' => 'Pengenalan komponen-komponen kelistrikan pada kendaraan',
                        ],
                        [
                            'lecture_title' => 'Sistem Pengisian (Charging System)',
                            'video_url' => 'https://www.youtube.com/watch?v=4YQGmSjMHpQ',
                            'url' => 'https://www.youtube.com/embed/4YQGmSjMHpQ',
                            'content' => 'Cara kerja alternator dan sistem pengisian aki',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Sistem Starter',
                    'lectures' => [
                        [
                            'lecture_title' => 'Komponen Sistem Starter',
                            'video_url' => 'https://www.youtube.com/watch?v=RXrT2JVeFlU',
                            'url' => 'https://www.youtube.com/embed/RXrT2JVeFlU',
                            'content' => 'Motor starter, solenoid, dan rangkaian starter',
                        ],
                        [
                            'lecture_title' => 'Troubleshooting Sistem Starter',
                            'video_url' => 'https://www.youtube.com/watch?v=QQCaKJnXACc',
                            'url' => 'https://www.youtube.com/embed/QQCaKJnXACc',
                            'content' => 'Diagnosa dan perbaikan masalah pada sistem starter',
                        ]
                    ]
                ]
            ],

            'Engine Tune Up dan Maintenance' => [
                [
                    'section_name' => 'Dasar Engine Tune Up',
                    'lectures' => [
                        [
                            'lecture_title' => 'Apa itu Tune Up?',
                            'video_url' => 'https://www.youtube.com/watch?v=dUkfKJlMTNA',
                            'url' => 'https://www.youtube.com/embed/dUkfKJlMTNA',
                            'content' => 'Pengertian tune up dan manfaatnya untuk mesin',
                        ],
                        [
                            'lecture_title' => 'Komponen yang di Tune Up',
                            'video_url' => 'https://www.youtube.com/watch?v=mqM8-wXjlRY',
                            'url' => 'https://www.youtube.com/embed/mqM8-wXjlRY',
                            'content' => 'Komponen mesin yang perlu di-tune up secara berkala',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Maintenance Berkala',
                    'lectures' => [
                        [
                            'lecture_title' => 'Jadwal Maintenance Kendaraan',
                            'video_url' => 'https://www.youtube.com/watch?v=qRJMKZSKhj8',
                            'url' => 'https://www.youtube.com/embed/qRJMKZSKhj8',
                            'content' => 'Jadwal perawatan berkala berdasarkan kilometer dan waktu',
                        ],
                        [
                            'lecture_title' => 'Ganti Oli dan Filter',
                            'video_url' => 'https://www.youtube.com/watch?v=JfwMtBz0MfE',
                            'url' => 'https://www.youtube.com/embed/JfwMtBz0MfE',
                            'content' => 'Cara mengganti oli mesin dan berbagai jenis filter',
                        ]
                    ]
                ]
            ],

            // AKL Courses
            'Dasar-dasar Akuntansi Perusahaan' => [
                [
                    'section_name' => 'Pengenalan Akuntansi',
                    'lectures' => [
                        [
                            'lecture_title' => 'Konsep Dasar Akuntansi',
                            'video_url' => 'https://www.youtube.com/watch?v=TqCVq8JTVVc',
                            'url' => 'https://www.youtube.com/embed/TqCVq8JTVVc',
                            'content' => 'Pengertian akuntansi dan fungsinya dalam bisnis',
                        ],
                        [
                            'lecture_title' => 'Persamaan Dasar Akuntansi',
                            'video_url' => 'https://www.youtube.com/watch?v=mVrM3QrZzR8',
                            'url' => 'https://www.youtube.com/embed/mVrM3QrZzR8',
                            'content' => 'Aset = Liabilitas + Ekuitas dan aplikasinya',
                        ],
                        [
                            'lecture_title' => 'Jenis-jenis Akun',
                            'video_url' => 'https://www.youtube.com/watch?v=4kHfzfhQJgE',
                            'url' => 'https://www.youtube.com/embed/4kHfzfhQJgE',
                            'content' => 'Klasifikasi akun dalam akuntansi dan karakteristiknya',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Jurnal dan Posting',
                    'lectures' => [
                        [
                            'lecture_title' => 'Cara Membuat Jurnal',
                            'video_url' => 'https://www.youtube.com/watch?v=8rOjBR8VdkY',
                            'url' => 'https://www.youtube.com/embed/8rOjBR8VdkY',
                            'content' => 'Teknik mencatat transaksi dalam jurnal umum',
                        ],
                        [
                            'lecture_title' => 'Posting ke Buku Besar',
                            'video_url' => 'https://www.youtube.com/watch?v=IeBzbVHLa8U',
                            'url' => 'https://www.youtube.com/embed/IeBzbVHLa8U',
                            'content' => 'Cara memposting jurnal ke buku besar',
                        ]
                    ]
                ]
            ],

            'Aplikasi Komputer Akuntansi' => [
                [
                    'section_name' => 'Pengenalan Software Akuntansi',
                    'lectures' => [
                        [
                            'lecture_title' => 'Jenis Software Akuntansi',
                            'video_url' => 'https://www.youtube.com/watch?v=aSz5dVbNGto',
                            'url' => 'https://www.youtube.com/embed/aSz5dVbNGto',
                            'content' => 'Berbagai macam software akuntansi dan kelebihannya',
                        ],
                        [
                            'lecture_title' => 'Menggunakan MYOB',
                            'video_url' => 'https://www.youtube.com/watch?v=g7WdXFqHpMU',
                            'url' => 'https://www.youtube.com/embed/g7WdXFqHpMU',
                            'content' => 'Tutorial dasar menggunakan MYOB Accounting',
                        ]
                    ]
                ]
            ],

            // BDP Courses
            'Digital Marketing untuk UMKM' => [
                [
                    'section_name' => 'Pengenalan Digital Marketing',
                    'lectures' => [
                        [
                            'lecture_title' => 'Apa itu Digital Marketing?',
                            'video_url' => 'https://www.youtube.com/watch?v=nU-IIXBWlS4',
                            'url' => 'https://www.youtube.com/embed/nU-IIXBWlS4',
                            'content' => 'Konsep dasar digital marketing dan manfaatnya untuk UMKM',
                        ],
                        [
                            'lecture_title' => 'Strategi Digital Marketing',
                            'video_url' => 'https://www.youtube.com/watch?v=jrGMt3i4xhE',
                            'url' => 'https://www.youtube.com/embed/jrGMt3i4xhE',
                            'content' => 'Berbagai strategi digital marketing yang efektif',
                        ]
                    ]
                ],
                [
                    'section_name' => 'Social Media Marketing',
                    'lectures' => [
                        [
                            'lecture_title' => 'Marketing di Instagram',
                            'video_url' => 'https://www.youtube.com/watch?v=l8lsGTNiKyc',
                            'url' => 'https://www.youtube.com/embed/l8lsGTNiKyc',
                            'content' => 'Strategi pemasaran produk melalui Instagram',
                        ],
                        [
                            'lecture_title' => 'Facebook Ads untuk Pemula',
                            'video_url' => 'https://www.youtube.com/watch?v=0aOKIhQXFW8',
                            'url' => 'https://www.youtube.com/embed/0aOKIhQXFW8',
                            'content' => 'Cara membuat iklan Facebook yang efektif',
                        ]
                    ]
                ]
            ],

            'Manajemen Toko Online (E-Commerce)' => [
                [
                    'section_name' => 'Membuat Toko Online',
                    'lectures' => [
                        [
                            'lecture_title' => 'Platform E-Commerce',
                            'video_url' => 'https://www.youtube.com/watch?v=3PfSNu8o9cY',
                            'url' => 'https://www.youtube.com/embed/3PfSNu8o9cY',
                            'content' => 'Memilih platform e-commerce yang tepat untuk bisnis',
                        ],
                        [
                            'lecture_title' => 'Cara Jualan di Shopee',
                            'video_url' => 'https://www.youtube.com/watch?v=6UKEWOiZbJA',
                            'url' => 'https://www.youtube.com/embed/6UKEWOiZbJA',
                            'content' => 'Tutorial lengkap berjualan di marketplace Shopee',
                        ]
                    ]
                ]
            ],

            // Mata Pelajaran Umum
            'Bahasa Inggris untuk Komunikasi Bisnis' => [
                [
                    'section_name' => 'Business English Basics',
                    'lectures' => [
                        [
                            'lecture_title' => 'Business Vocabulary',
                            'video_url' => 'https://www.youtube.com/watch?v=6sALCYCCYmE',
                            'url' => 'https://www.youtube.com/embed/6sALCYCCYmE',
                            'content' => 'Kosakata bahasa Inggris untuk dunia bisnis',
                        ],
                        [
                            'lecture_title' => 'Business Email Writing',
                            'video_url' => 'https://www.youtube.com/watch?v=53h9lMFrDes',
                            'url' => 'https://www.youtube.com/embed/53h9lMFrDes',
                            'content' => 'Cara menulis email bisnis yang profesional',
                        ]
                    ]
                ]
            ],

            'Matematika Terapan untuk SMK' => [
                [
                    'section_name' => 'Matematika Dasar',
                    'lectures' => [
                        [
                            'lecture_title' => 'Operasi Hitung Dasar',
                            'video_url' => 'https://www.youtube.com/watch?v=M8lqey9iKPU',
                            'url' => 'https://www.youtube.com/embed/M8lqey9iKPU',
                            'content' => 'Operasi penjumlahan, pengurangan, perkalian, dan pembagian',
                        ],
                        [
                            'lecture_title' => 'Persentase dan Proporsi',
                            'video_url' => 'https://www.youtube.com/watch?v=YWHx0RsRNzI',
                            'url' => 'https://www.youtube.com/embed/YWHx0RsRNzI',
                            'content' => 'Menghitung persentase dan proporsi dalam kehidupan sehari-hari',
                        ]
                    ]
                ]
            ]
        ];

        // Process each course content
        foreach ($courseContents as $courseName => $sections) {
            $course = Course::where('course_name', $courseName)->first();
            
            if ($course) {
                $sectionOrder = 1;
                
                foreach ($sections as $sectionData) {                    $section = CourseSection::create([
                        'course_id' => $course->id,
                        'section_title' => $sectionData['section_name'],
                        'sort_order' => $sectionOrder++,
                    ]);
                    
                    $lectureOrder = 1;
                      foreach ($sectionData['lectures'] as $lectureData) {
                        CourseLecture::create([
                            'course_id' => $course->id,
                            'section_id' => $section->id,
                            'lecture_title' => $lectureData['lecture_title'],
                            'video_url' => $lectureData['video_url'] ?? null,
                            'url' => $lectureData['url'] ?? null,
                            'content' => $lectureData['content'],
                            'video_duration' => $lectureData['video_duration'] ?? rand(5, 15), // Random duration if not specified
                            'sort_order' => $lectureOrder++,
                        ]);
                    }
                }
            }
        }
    }
}
