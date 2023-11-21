<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            [
                'id'=>1,
                'name' => 'Admin',
                'type' => 'admin',
                'mobile' => 3200000000,
                'email' => 'admin@admin.com',
                'password' => $password,
                'image' => '',
                'status' => 1,
            ],
            [
                'id'=>2,
                'name' => 'John',
                'type' => 'subadmin',
                'mobile' => 5500000000,
                'email' => 'john@admin.com',
                'password' => $password,
                'image' => '',
                'status' => 1,
            ],
            [
                'id'=>3,
                'name' => 'Puta',
                'type' => 'subadmin',
                'mobile' => 1200000000,
                'email' => 'puta@admin.com',
                'password' => $password,
                'image' => '',
                'status' => 1,
            ],
        ];
        Admin::insert($adminRecords);
    }
}
