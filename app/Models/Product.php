<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Productimage;
use App\Models\Attribute;

class Product extends Model
{
    use HasFactory;

    /**
     * Define a relationship with the Category model.
     *
     * This function establishes a "belongsTo" relationship between the Product and Category models.
     * It associates a product with a category based on the category_id foreign key in the products table.
     * The "with" method eager loads the parentcategory relationship from the Category model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->with('parentcategory');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    /**
     * Define a static method to retrieve product filters for clothing.
     *
     * This method provides predefined arrays for various clothing filters such as fabric, sleeve, pattern, fit, and occasion.
     * These arrays can be used for filtering products on the frontend.
     *
     * @return array
     */
    public static function productFilters()
    {
        $productsFilters['fabricArray'] = ['Cotton', 'Polyester', 'Wool'];
        $productsFilters['sleeveArray'] = ['Full Sleeve', 'Half Sleeve', 'Sleeveless'];
        $productsFilters['patternArray'] = ['Checked', 'Plain', 'Printed', 'Self', 'Solid'];
        $productsFilters['fitArray'] = ['Regular', 'Slim', 'Plus'];
        $productsFilters['occasionArray'] = ['Casual', 'Formal'];
        return $productsFilters;
    }

    /**
     * Define a relationship with the Productimage model.
     *
     * This function establishes a "hasMany" relationship between the Product and Productimage models.
     * It indicates that a product can have multiple images associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Define a relationship with the Attribute model.
     *
     * This function establishes a "hasMany" relationship between the Product and Attribute models.
     * It indicates that a product can have multiple attributes associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
}
