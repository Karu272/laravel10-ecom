<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Productimage;

class ProductimageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productimageRecord = [
            [
                'id' => 1,
                'product_id'=> 1,
                'image'=> '1.jpg',
                'image_sort'=> 1,
                'status' => 1,
            ],
            [
                'id' => 2,
                'product_id'=> 2,
                'image'=> '1.jpg',
                'image_sort'=> 2,
                'status' => 1,
            ],
            [
                'id' => 3,
                'product_id'=> 3,
                'image'=> '1.jpg',
                'image_sort'=> 3,
                'status' => 1,
            ],
        ];

        Productimage::insert($productimageRecord);
    }
}
