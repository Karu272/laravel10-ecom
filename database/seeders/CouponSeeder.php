<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couponRecods = [
            [
                'id' => 1,
                'coupon_option' => 'Manual',
                'coupon_code' => 'TEST10',
                'categories' => '["7","8","9"]',
                'brands' => '["1","2","3"]',
                'users' => '["1","2"]',
                'coupon_type' => 'Single',
                'amount_type' => 'Procentage',
                'amount' => '10',
                'expiry_date' => '2024-04-29',
                'status' => 1,
            ],
            [
                'id' => 2,
                'coupon_option' => 'Manual',
                'coupon_code' => 'TEST20',
                'categories' => '["7","8","9"]',
                'brands' => '["1","2","3"]',
                'users' => 'hej@yopmail.com',
                'coupon_type' => 'Single',
                'amount_type' => 'Procentage',
                'amount' => '20',
                'expiry_date' => '2024-04-29',
                'status' => 1,
            ],
            [
                'id' => 3,
                'coupon_option' => 'Automatic',
                'coupon_code' => 'fuandurmum',
                'categories' => '["7","8","9"]',
                'brands' => '["1","2","3"]',
                'users' => 'bobo@yopmail.com',
                'coupon_type' => 'Multiple',
                'amount_type' => 'Fixed',
                'amount' => '100',
                'expiry_date' => '2024-04-29',
                'status' => 1,
            ]
        ];
        Coupon::insert($couponRecods);
    }
}
