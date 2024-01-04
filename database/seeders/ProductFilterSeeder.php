<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFilter;

class ProductFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filterRecords = [
            [
                'id' => 1,
                'filter_name' => 'Fabric',
                'filter_value' => 'Polyester',
                'sort' => 1,
                'status' => 1,
            ],
            [
                'id' => 2,
                'filter_name' => 'Fabric',
                'filter_value' => 'Cotton',
                'sort' => 2,
                'status' => 1,
            ],
            [
                'id' => 3,
                'filter_name' => 'Fabric',
                'filter_value' => 'Wool',
                'sort' => 3,
                'status' => 1,
            ],
            [
                'id' => 4,
                'filter_name' => 'Fit',
                'filter_value' => 'Regular',
                'sort' => 1,
                'status' => 1,
            ],
            [
                'id' => 5,
                'filter_name' => 'Fit',
                'filter_value' => 'Casual',
                'sort' => 2,
                'status' => 1,
            ],
            [
                'id' => 6,
                'filter_name' => 'Fit',
                'filter_value' => 'Plus',
                'sort' => 3,
                'status' => 1,
            ],
            [
                'id' => 7,
                'filter_name' => 'Sleeve',
                'filter_value' => 'Full sleeve',
                'sort' => 1,
                'status' => 1,
            ],
            [
                'id' => 8,
                'filter_name' => 'Sleeve',
                'filter_value' => 'Half sleeve',
                'sort' => 2,
                'status' => 1,
            ],
            [
                'id' => 9,
                'filter_name' => 'Sleeve',
                'filter_value' => 'Sleeveless',
                'sort' => 3,
                'status' => 1,
            ],
            [
                'id' => 10,
                'filter_name' => 'Pattern',
                'filter_value' => 'Plain',
                'sort' => 1,
                'status' => 1,
            ],
            [
                'id' => 11,
                'filter_name' => 'Pattern',
                'filter_value' => 'Printed',
                'sort' => 2,
                'status' => 1,
            ],
            [
                'id' => 12,
                'filter_name' => 'Occasion',
                'filter_value' => 'Casual',
                'sort' => 1,
                'status' => 1,
            ],
            [
                'id' => 13,
                'filter_name' => 'Occasion',
                'filter_value' => 'Formal',
                'sort' => 2,
                'status' => 1,
            ],

        ];
        ProductFilter::insert($filterRecords);
    }
}
