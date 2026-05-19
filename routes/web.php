<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiyRecipeController;
use App\Http\Controllers\Admin\DiyRecipeComponentController;
use App\Http\Controllers\Admin\DiyComponentOptionController;
use App\Http\Controllers\CheckoutController;



Route::get('/', [HomeController::class, 'index']);
Route::get('/projects/{id}', [HomeController::class, 'show']);
Route::get('/diy-projects', [DiyController::class, 'index'])->name('diy.index');
Route::get('/diy-projects/{project}', [DiyController::class, 'showProject'])->name('diy.project');
Route::get('/diy-recipes/{recipe}', [DiyController::class, 'showRecipe'])->name('diy.recipe');
Route::post('/diy-recipes/{recipe}/calculate', [DiyController::class, 'calculate'])->name('diy.calculate');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');
Route::resource('/admin/products', ProductController::class)
    ->names('admin.products');
Route::resource('/admin/recipes', DiyRecipeController::class)
    ->names('admin.recipes');
Route::post('/admin/recipes/{recipe}/components', [DiyRecipeComponentController::class, 'store'])
    ->name('admin.recipe-components.store');

#Bagian Kelola Komponen
Route::delete('/admin/recipe-components/{component}', [DiyRecipeComponentController::class, 'destroy'])
    ->name('admin.recipe-components.destroy');

Route::post('/admin/recipe-components/{component}/options', [DiyComponentOptionController::class, 'store'])
    ->name('admin.component-options.store');

Route::delete('/admin/component-options/{option}', [DiyComponentOptionController::class, 'destroy'])
    ->name('admin.component-options.destroy');

    //Checkout
Route::get('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/invoice/{order}', [CheckoutController::class, 'invoice'])
    ->name('checkout.invoice');
