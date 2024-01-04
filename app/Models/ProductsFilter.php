<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Brand;
use Arr;

class ProductsFilter extends Model
{
    use HasFactory;
    protected $table = 'product_filters';

    public static function getColors($catIds)
    {
        $getProductIds = Product::select('id')->whereIn('category_id', $catIds)->pluck('id');
        // dd($getProductIds);
        $getProductColors = Product::select('family_color')->whereIn('id', $getProductIds)->groupBy('family_color')->pluck('family_color');
        // dd($getProductColors);
        return $getProductColors;
    }

    public static function getSizes($catIds)
    {
        $getProductIds = Product::select('id')->whereIn('category_id', $catIds)->pluck('id');
        $getProductSizes = Attribute::select('size')->where('status', 1)->whereIn('product_id', $getProductIds)->groupBy('size')->pluck('size');
        // dd($getProductSizes);
        return $getProductSizes;
    }

    public static function getBrands($catIds)
    {
        $getProductIds = Product::select('id')->whereIn('category_id', $catIds)->pluck('id');
        $getProductBrandIds = Product::select('brand_id')->whereIn('id', $getProductIds)->groupBy('brand_id')->pluck('brand_id');
        $getProductBrands = Brand::select('id', 'brand_name')->where('status', 1)->whereIn('id', $getProductBrandIds)->orderBy('brand_name', 'ASC')->get()->toArray();
        //dd($getProductBrands);
        return $getProductBrands;
    }

    public static function getDynamicFilters($catIds)
    {
        $getProductIds = Product::select('id')->whereIn('category_id', $catIds)->pluck('id');
        $getFilterColumns = ProductsFilter::select('filter_name')->pluck('filter_name')->toArray();
        //dd($getFilterColumns);
        // Get filter values for the products
        if (count($getFilterColumns) > 0) {
            // If there are filter columns, get filter values for those columns
            $getFilterValues = Product::select($getFilterColumns)->whereIn('id', $getProductIds)->where('status', 1)->get()->toArray();
        } else {
            // If no filter columns, get all product values
            $getFilterValues = Product::whereIn('id', $getProductIds)->where('status', 1)->get()->toArray();
        }
        // Flatten array to single dimension, remove duplicates, and filter out empty values
        $getFilterValues = array_filter(array_unique(\Illuminate\Support\Arr::flatten($getFilterValues)));
        // Explanation:
        // 1. Flatten the multi-dimensional array into a single array
        // 2. Remove any duplicate values
        // 3. Filter out any empty/false values
        // This results in a clean array of unique filter values across all products
        $getCategoryFilterColumns = ProductsFilter::select('filter_name')->whereIn('filter_value', $getFilterValues)->groupBy('filter_name')->orderBy('sort', 'ASC')->where('status', 1)->pluck('filter_name')->toArray();

        return $getCategoryFilterColumns;
    }
    /**
     * Retrieve selected filters for a specific filter name and category IDs.
     *
     * @param string $filter_name The name of the filter for which values are to be retrieved.
     * @param array $catIds An array of category IDs to filter the products.
     * @return array An array containing the selected filter values.
     */
    public static function selectedFilters($filter_name, $catIds)
    {
        // Query the 'Product' model to select the specified filter column for products
        // within the provided category IDs, grouping them by the specified filter column
        $productFilters = Product::select($filter_name)->whereIn('category_id', $catIds)->groupBy($filter_name)->get()->toArray();

        // Flatten the multi-dimensional array into a single-dimensional array
        $productFilters = array_filter(\Illuminate\Support\Arr::flatten($productFilters));

        // Return the array containing the selected filter values
        return $productFilters;
    }

    public static function filterTypes(){
        $filterTypes = ProductsFilter::select('filter_name')->where('status', 1)->groupBy('filter_name')->get()->toArray();
        $filterTypes = Arr::flatten($filterTypes);
        return $filterTypes;
    }
}

