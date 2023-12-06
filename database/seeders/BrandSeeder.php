<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandRecords = [
            [
                'id'=> 1,
                'brand_name'=> 'Nike',
                'image'=> '',
                'brand_logo'=> '',
                'brand_discount'=> 0,
                'description'=> 'Nike panties are sexy',
                'url'=> 'nike',
                'meta_title'=> 'Nike meta title',
                'meta_description'=> 'SQL crap text',
                'meta_keywords'=> 'panties pekpek sport girl',
                'status'=> 1,
            ],
            [
                'id'=> 2,
                'brand_name'=> 'Puma',
                'image'=> '',
                'brand_logo'=> '',
                'brand_discount'=> 0,
                'description'=> 'Puma panties are sexy',
                'url'=> 'puma',
                'meta_title'=> 'Puma meta title',
                'meta_description'=> 'SQL crap text',
                'meta_keywords'=> 'panties pekpek sport girl',
                'status'=> 1,
            ],
            [
                'id'=> 3,
                'brand_name'=> 'Victorias Secret',
                'image'=> '',
                'brand_logo'=> '',
                'brand_discount'=> 0,
                'description'=> 'Victorias Secret panties are sexy',
                'url'=> 'vs',
                'meta_title'=> 'Victorias Secret meta title',
                'meta_description'=> 'SQL crap text',
                'meta_keywords'=> 'panties pekpek sport girl',
                'status'=> 1,
            ],
        ];
        Brand::insert($brandRecords);
    }
}
