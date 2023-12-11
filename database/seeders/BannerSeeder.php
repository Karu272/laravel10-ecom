<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecords = [
            [
                'id'=> 1,
                'image' => '',
                'type' => 'banner',
                'link' => 'tshirts',
                'title' => 'tshirts',
                'alt' => 'tshirts',
                'sort' => '',
                'status' => 1,
            ],
            [
                'id'=> 2,
                'image' => '',
                'type' => 'banner',
                'link' => 'pants',
                'title' => 'pants',
                'alt' => 'pants',
                'sort' => '',
                'status' => 1,
            ],
        ];
        Banner::insert($bannerRecords);
    }
}
