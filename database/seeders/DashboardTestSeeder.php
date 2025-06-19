<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Payment;

class DashboardTestSeeder extends Seeder
{
    /**
     * Run the database seeder for testing dashboard with real data.
     */
    public function run(): void
    {
        // Ambil user student untuk test data
        $student = User::where('email', 'student@example.com')->first();
        
        if (!$student) {
            $this->command->error('User student@example.com tidak ditemukan. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        // Ambil beberapa course yang ada
        $courses = Course::limit(5)->get();
        
        if ($courses->isEmpty()) {
            $this->command->error('Tidak ada course ditemukan. Jalankan CourseSeeder terlebih dahulu.');
            return;
        }        // Buat test payment records
        $payments = [];
        for ($i = 1; $i <= 3; $i++) {
            $payment = Payment::create([
                'transaction_id' => 'TEST_TRANS_' . $i . '_' . time(),
                'name' => 'Test Payment ' . $i,
                'email' => $student->email,
                'payment_type' => 'Stripe',
                'status' => 'completed',
                'total_amount' => '100000',
                'invoice_no' => 'INV_' . $i . '_' . date('Y'),
                'order_date' => date('d-m-Y'),
                'order_month' => date('F'),
                'order_year' => date('Y'),
            ]);
            $payments[] = $payment;
        }

        // Buat test orders (enrolled courses)
        foreach ($courses->take(3) as $index => $course) {
            Order::create([
                'payment_id' => $payments[$index]->id,
                'user_id' => $student->id,
                'course_id' => $course->id,
                'instructor_id' => $course->instructor_id ?? 1,
                'course_title' => $course->course_name,
                'price' => $course->selling_price ?? 100000,
                'amount' => $course->selling_price ?? 100000,
                'status' => 'completed', // Status completed untuk enrolled courses
            ]);
        }        // Buat test wishlist (tambahkan lebih banyak)
        foreach ($courses->skip(3)->take(4) as $course) {
            Wishlist::firstOrCreate([
                'user_id' => $student->id,
                'course_id' => $course->id,
            ]);
        }

        // Buat test messages
        $messages = [
            [
                'user_id' => $student->id,
                'from_user_id' => null, // System message
                'subject' => 'Welcome to EDUGO!',
                'message' => 'Welcome to EDUGO platform! Thank you for joining us. Start exploring our courses and enhance your skills.',
                'type' => 'system',
                'is_read' => false,
            ],
            [
                'user_id' => $student->id,
                'from_user_id' => 1, // Admin message
                'subject' => 'Your Course Purchase Confirmation',
                'message' => 'Thank you for purchasing our courses. You can now access your enrolled courses from the "My Courses" section.',
                'type' => 'course',
                'is_read' => false,
            ],
            [
                'user_id' => $student->id,
                'from_user_id' => null,
                'subject' => 'Payment Successful',
                'message' => 'Your payment has been processed successfully. You now have access to your purchased courses.',
                'type' => 'payment',
                'is_read' => true,
            ],
            [
                'user_id' => $student->id,
                'from_user_id' => 1,
                'subject' => 'New Course Recommendation',
                'message' => 'Based on your learning interests, we have some new course recommendations for you. Check them out!',
                'type' => 'general',
                'is_read' => false,
            ],
        ];

        foreach ($messages as $messageData) {
            \App\Models\Message::create($messageData);
        }

        $this->command->info('Dashboard test data berhasil dibuat!');
        $this->command->info('Login dengan: student@example.com / password');
    }
}
