<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Belajar Pemrograman dari Ahlinya',
                'short_description' => 'Kursus Pemrograman',
                'image' => 'slider1.jpg',
                'video_url' => 'https://www.youtube.com/watch?v=example1',
            ],
            [
                'title' => 'Kuasai Pengembangan Web',
                'short_description' => 'Pengembangan Web',
                'image' => 'slider2.jpg',
                'video_url' => 'https://www.youtube.com/watch?v=example2',
            ],
            [
                'title' => 'Ilmu Data & Machine Learning',
                'short_description' => 'Ilmu Data',
                'image' => 'slider3.jpg',
                'video_url' => 'https://www.youtube.com/watch?v=example3',
            ]
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
