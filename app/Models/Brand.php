<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'brand_name', // Add any other attributes you want to be mass assignable
        'brand_discount',
        'description',
        'url',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
        'image',
        'brand_logo',
        // Add other attributes as needed
    ];
}
