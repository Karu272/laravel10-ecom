<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords = [
            [
                'id' => 1,
                'parent_id' => 0,
                'category_name' => 'Clothing',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of shirts',
                'url' => 'clothing',
                'status' => 1,
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'category_name' => 'Electronics',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of electronics',
                'url' => 'electronics',
                'status' => 1,
            ],
            [
                'id' => 3,
                'parent_id' => 0,
                'category_name' => 'Appliences',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of appliences',
                'url' => 'appliences',
                'status' => 1,
            ],
            [
                'id' => 4,
                'parent_id' => 0,
                'category_name' => 'Men',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of men',
                'url' => 'men',
                'status' => 1,
            ],
            [
                'id' => 5,
                'parent_id' => 0,
                'category_name' => 'Women',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of women',
                'url' => 'women',
                'status' => 1,
            ],
            [
                'id' => 6,
                'parent_id' => 0,
                'category_name' => 'Kids',
                'category_img' => '',
                'category_discount' => 0,
                'description' => 'Full of kids',
                'url' => 'kids',
                'status' => 1,
            ],
        ];

        Category::insert($categoryRecords);
    }
}
