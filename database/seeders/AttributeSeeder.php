<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributesRecords = [
            [
                'id' => 1,
                'product_id' => 1,
                'size'=> 'Small',
                'sku'=> 'BP001S',
                'price' => 450,
                'stock' => 100,
                'status' => 1,
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'size'=> 'Medium',
                'sku'=> 'GP001S',
                'price' => 550,
                'stock' => 100,
                'status' => 1,
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'size'=> 'Large',
                'sku'=> 'BP001S',
                'price' => 250,
                'stock' => 100,
                'status' => 1,
            ],
        ];
        Attribute::insert($attributesRecords);
    }
}
