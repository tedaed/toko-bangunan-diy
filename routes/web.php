<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiyRecipeController;




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