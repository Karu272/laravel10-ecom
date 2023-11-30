<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    // sendind this function to products.blade index function
    public function category() {
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }
    // parentcategory() comes from the category model

    public static function productFilters() {
        // product filter for clothing
        $productsFilters['fabricArray'] = ['Cotton','Polyester','Wool'];
        $productsFilters['sleeveArray'] = ['Full Sleeve','Half Sleeve','Sleeveless'];
        $productsFilters['petternArray'] = ['Checked','Plain','Printed','Self','Solid'];
        $productsFilters['fitArray'] = ['Regular','Slim','Plus'];
        $productsFilters['occasionArray'] = ['Casual','Formal'];
        return $productsFilters;
    }
}
