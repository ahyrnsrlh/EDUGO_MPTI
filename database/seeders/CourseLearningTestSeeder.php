<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;

class CourseLearningTestSeeder extends Seeder
{
    /**
     * Run the database seeder for course learning test data.
     */
    public function run(): void
    {
        // Ambil beberapa course yang ada
        $courses = Course::limit(3)->get();
        
        if ($courses->isEmpty()) {
            $this->command->error('Tidak ada course ditemukan. Jalankan CourseSeeder terlebih dahulu.');
            return;
        }

        foreach ($courses as $course) {
            // Buat sections untuk setiap course
            $sections = [
                [
                    'section_title' => 'Introduction',
                    'lectures' => [
                        [
                            'lecture_title' => 'Welcome to the Course',
                            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'content' => 'Welcome to this comprehensive course! In this introduction, we will cover what you can expect to learn and how to get the most out of this course.',
                            'video_duration' => 5.30,
                        ],
                        [
                            'lecture_title' => 'Course Overview',
                            'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                            'content' => 'This lecture provides a complete overview of the course structure, learning objectives, and prerequisites.',
                            'video_duration' => 8.45,
                        ],
                    ]
                ],
                [
                    'section_title' => 'Getting Started',
                    'lectures' => [
                        [
                            'lecture_title' => 'Setting Up Your Environment',
                            'url' => 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ',
                            'content' => 'Learn how to set up your development environment and install all necessary tools for this course.',
                            'video_duration' => 12.15,
                        ],
                        [
                            'lecture_title' => 'Basic Concepts',
                            'url' => 'https://www.youtube.com/watch?v=YQHsXMglC9A',
                            'content' => 'Understanding the fundamental concepts that form the foundation of what we will be learning in this course.',
                            'video_duration' => 15.20,
                        ],
                        [
                            'lecture_title' => 'Hands-on Exercise',
                            'url' => null,
                            'content' => 'Practice what you have learned with this hands-on exercise. Follow the instructions carefully and try to implement the solution yourself.',
                            'video_duration' => null,
                        ],
                    ]
                ],
                [
                    'section_title' => 'Advanced Topics',
                    'lectures' => [
                        [
                            'lecture_title' => 'Advanced Techniques',
                            'url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0',
                            'content' => 'Dive into advanced techniques and best practices that will help you master this subject.',
                            'video_duration' => 18.30,
                        ],
                        [
                            'lecture_title' => 'Real-world Applications',
                            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'content' => 'See how these concepts apply in real-world scenarios with practical examples and case studies.',
                            'video_duration' => 22.45,
                        ],
                    ]
                ],
            ];

            foreach ($sections as $sectionData) {
                $section = CourseSection::create([
                    'course_id' => $course->id,
                    'section_title' => $sectionData['section_title'],
                ]);

                foreach ($sectionData['lectures'] as $lectureData) {
                    CourseLecture::create([
                        'course_id' => $course->id,
                        'section_id' => $section->id,
                        'lecture_title' => $lectureData['lecture_title'],
                        'url' => $lectureData['url'],
                        'content' => $lectureData['content'],
                        'video_duration' => $lectureData['video_duration'],
                    ]);
                }
            }
        }

        $this->command->info('Course learning test data berhasil dibuat!');
        $this->command->info('Total courses: ' . $courses->count());
        $this->command->info('Total sections: ' . CourseSection::count());
        $this->command->info('Total lectures: ' . CourseLecture::count());
    }
}
