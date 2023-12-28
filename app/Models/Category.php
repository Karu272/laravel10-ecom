<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // this is send to products model
    public function parentcategory()
    {
        return $this->hasOne(Category::class, 'parent_id', 'id')
            ->select('id', 'category_name', 'url')
            ->where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }

    public static function getCategories()
    {
        $getCategories = Category::with(
            [
                'subcategories' => function ($query) {
                    $query->with('subcategories');
                }
            ]
        )->where('parent_id', 0)->where('status', 1)->get()->toArray();
        return $getCategories;
    }

    public static function categoryDetails($url)
    {
        // Retrieve the first matching category
        $categoryDetails = Category::select('id', 'parent_id', 'category_name', 'url')
            ->with('subcategories.subcategories') // Eager load subsubcategories
            ->where('url', $url) // Filter by the URL parameter
            ->first(); // Retrieve the first matching category

        // Check if a category was found
        if ($categoryDetails) {
            // Convert the result to an array
            $categoryDetails = $categoryDetails->toArray();

            // Initialize an array to store category IDs
            $catIDs = array();

            // Add the main category ID to the $catIDs array
            $catIDs[] = $categoryDetails['id'];

            // Loop through subcategories and add their IDs to the $catIDs array
            foreach ($categoryDetails['subcategories'] as $subCat) {
                $catIDs[] = $subCat['id'];

                // Loop through subsubcategories and add their IDs to the $catIDs array
                foreach ($subCat['subcategories'] as $subSubCat) {
                    $catIDs[] = $subSubCat['id'];
                }
            }

            // Initialize breadcrumbs string
            $breadcrumbs = '';

            // Start with the current category
            $currentCategory = $categoryDetails;

            // Loop through each level of the hierarchy until the parent_id is 0
            while ($currentCategory['parent_id'] !== 0) {
                $breadcrumbs = '<a href="' . url($currentCategory['url']) . '"> ' . $currentCategory['category_name'] . ' </a>&nbsp;&rarr;&nbsp;' . $breadcrumbs;

                // Fetch the parent category
                $currentCategory = Category::select('id', 'parent_id', 'category_name', 'url')->find($currentCategory['parent_id'])->toArray();
            }

            // Add the main category to the breadcrumbs
            $breadcrumbs = '<a href="' . url($currentCategory['url']) . '"> ' . $currentCategory['category_name'] . ' </a>&nbsp;&rarr;&nbsp;' . $breadcrumbs;

            // Return an array containing category IDs and the complete category details
            return [
                'catIDs' => $catIDs,
                'categoryDetails' => $categoryDetails,
                'breadcrumbs' => $breadcrumbs,
            ];
        }

        // Return an empty array if no category is found
        return [];
    }

}
