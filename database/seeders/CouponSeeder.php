<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
use App\Models\User;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = User::where('role', 'instructor')->get();
        
        $coupons = [
            [
                'coupon_name' => 'WELCOME20',
                'coupon_discount' => '20',
                'coupon_validity' => now()->addDays(30)->format('Y-m-d'),
                'status' => 1,
            ],
            [
                'coupon_name' => 'SAVE50',
                'coupon_discount' => '50',
                'coupon_validity' => now()->addDays(15)->format('Y-m-d'),
                'status' => 1,
            ],
            [
                'coupon_name' => 'STUDENT15',
                'coupon_discount' => '15',
                'coupon_validity' => now()->addDays(60)->format('Y-m-d'),
                'status' => 1,
            ]
        ];

        foreach ($coupons as $couponData) {
            Coupon::create([
                'instructor_id' => $instructors->random()->id,
                'coupon_name' => $couponData['coupon_name'],
                'coupon_discount' => $couponData['coupon_discount'],
                'coupon_validity' => $couponData['coupon_validity'],
                'status' => $couponData['status'],
            ]);
        }
    }
}
