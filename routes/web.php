<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->group(function () {

    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);

    Route::middleware(['admin'])->group(function (){
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('logout', [AdminController::class,'logout'])->name('admin.login');
        /* ========== Admin Setup ========== */
        Route::match(['get', 'post'], 'update-password', [AdminController::class,'updatePassword'])->name('admin.update_password');
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword']);
        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class,'updateAdminDetails'])->name('admin.update_admin_details');
        Route::get('subadmins/subadmins', [AdminController::class,'subadmins'])->name('subadmins.subadmins');
        Route::post('update-subadmin-status', [AdminController::class,'updateSubadmin']);
        Route::match(['get','post'],'subadmins/add-edit-subadmin/{id?}', [AdminController::class,'editSubadmin'])->name('admin.subadmins.add_edit_subadmin');
        Route::get('delete-subadmin/{id}', [AdminController::class,'destroySubadmin']);
        Route::match(['get','post'],'subadmins/update-role/{id?}', [AdminController::class,'updateRole'])->name('admin.subadmins.update_role');

        /* ========== Cms Pages ========== */
        Route::get('pages/cms-pages', [AdminController::class,'index'])->name('admin.pages.cms_pages');
        Route::post('update-cms-pages-status', [AdminController::class,'update']);
        Route::match(['get','post'],'pages/add-edit-cmsPage/{id?}', [AdminController::class,'edit'])->name('admin.pages.add_edit_cmsPage');
        Route::get('delete-cmsPage/{id}', [AdminController::class,'destroy']);

        /* ========== E-com Pages ========== */
        Route::get('categories/categories', [CategoryController::class, 'categories'])->name('categories.categories');
        Route::match(['get','post'],'categories/add-edit-category/{id?}', [CategoryController::class,'edit'])->name('admin.categories.add_edit_category');
        Route::post('update-category-status', [CategoryController::class,'update']);
        Route::get('delete-category/{id}', [CategoryController::class,'destroy']);
    });

});
