<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsPage;

class CmsPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPagesRecords =[
            [
                'id' => 1,
                'title'=> 'About us',
                'description' => 'Another Sunday',
                'url'=> 'about-us',
                'meta_title'=> 'Coming later',
                'meta_description' => 'Coming later',
                'meta_keywords' => 'About usKeywords coming later',
                'status'=> 1,
            ],
            [
                'id' => 2,
                'title'=> 'Terms & Condition',
                'description' => 'Terms & Condition',
                'url'=> 'terms-conditions',
                'meta_title'=> 'Terms & Condition',
                'meta_description' => 'Terms & Condition',
                'meta_keywords' => 'Terms & Condition Keywords coming later',
                'status'=> 1,
            ],
            [
                'id' => 3,
                'title'=> 'Privacy Policy',
                'description' => 'Privacy Policy',
                'url'=> 'privacy-policy',
                'meta_title'=> 'Privacy Policy',
                'meta_description' => 'Privacy Policy',
                'meta_keywords' => 'Privacy Policy coming later',
                'status'=> 1,
            ]
        ];
        CmsPage::insert( $cmsPagesRecords );
    }
}
