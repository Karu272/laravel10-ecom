<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannersController;

use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Models\Category;

Route::namespace('App\Http\Controllers\Front')->group(function () {
    // Home page route
    Route::get('/', [IndexController::class, 'index']);
    // Listing products
    $catURLs = Category::select('url')->where('status',1)->pluck('url');
    //dd($catURLs);
    foreach($catURLs as $url) {
        Route::get('/' . $url, [FrontProductController::class, 'listing']);
    }

});

Route::prefix('admin')->group(function () {

    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);

    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.login');

        /* ========== Admin Setup ========== */
        // Admin
        Route::match(['get', 'post'], 'update-password', [AdminController::class, 'updatePassword'])->name('admin.update_password');
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword']);
        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails'])->name('admin.update_admin_details');
        // SubAdmin
        Route::get('subadmins/subadmins', [AdminController::class, 'subadmins'])->name('subadmins.subadmins');
        Route::post('update-subadmin-status', [AdminController::class, 'updateSubadmin']);
        Route::match(['get', 'post'], 'subadmins/add-edit-subadmin/{id?}', [AdminController::class, 'editSubadmin'])->name('admin.subadmins.add_edit_subadmin');
        Route::get('delete-subadmin/{id}', [AdminController::class, 'destroySubadmin']);
        Route::match(['get', 'post'], 'subadmins/update-role/{id?}', [AdminController::class, 'updateRole'])->name('admin.subadmins.update_role');

        /* ========== Cms Pages ========== */
        Route::get('pages/cms-pages', [AdminController::class, 'index'])->name('admin.pages.cms_pages');
        Route::post('update-cms-pages-status', [AdminController::class, 'update']);
        Route::match(['get', 'post'], 'pages/add-edit-cmsPage/{id?}', [AdminController::class, 'edit'])->name('admin.pages.add_edit_cmsPage');
        Route::get('delete-cmsPage/{id}', [AdminController::class, 'destroy']);

        /* ========== E-com Pages ========== */
        // Categories
        Route::get('categories/categories', [CategoryController::class, 'categories'])->name('admin.categories.categories');
        Route::match(['get', 'post'], 'categories/add-edit-category/{id?}', [CategoryController::class, 'edit'])->name('admin.categories.add_edit_category');
        Route::post('update-category-status', [CategoryController::class, 'update']);
        Route::get('delete-category/{id}', [CategoryController::class, 'destroy']);
        Route::get('delete-categoryimg/{id}', [CategoryController::class, 'destroycatimg']);
        // Products
        Route::get('products/products', [AdminProductController::class, 'index'])->name('admin.products.products');
        Route::post('update-product-status', [AdminProductController::class, 'update']);
        Route::match(['get', 'post'], 'products/add-edit-product/{id?}', [AdminProductController::class, 'edit'])->name('admin.products.add_edit_product');
        Route::get('delete-product/{id}', [AdminProductController::class, 'destroy']);
        Route::get('delete-product-video/{id}', [AdminProductController::class, 'destroyproVideo']);
        Route::get('delete-productimg/{id}', [AdminProductController::class, 'destroyproimg']);
        // Attribute
        Route::post('update-attribute-status', [AdminProductController::class, 'updateAtrStatus']);
        Route::get('delete-attribute/{id}', [AdminProductController::class, 'destroyattribute']);
        // Brands
        Route::get('brands/brands', [BrandController::class, 'index'])->name('admin.brands.brands');
        Route::post('update-brand-status', [BrandController::class, 'update']);
        Route::match(['get', 'post'], 'brands/add-edit-brand/{id?}', [BrandController::class, 'edit'])->name('admin.brands.add_edit_brand');
        Route::get('delete-brand/{id}', [BrandController::class, 'destroy']);
        Route::get('delete-brandimg/{id}', [BrandController::class, 'destroyImg']);
        Route::get('delete-brand-logo/{id}', [BrandController::class, 'destroyLogo']);
        // Banners
        Route::get('banners/banners', [BannersController::class, 'index'])->name('admin.banners.banners');
        Route::match(['get', 'post'], 'banners/add-edit-banner/{id?}', [BannersController::class, 'edit'])->name('admin.banners.add_edit_banner');
        Route::post('update-banner-status', [BannersController::class, 'update']);
        Route::get('delete-banner/{id}', [BannersController::class, 'destroy']);

    });

});


