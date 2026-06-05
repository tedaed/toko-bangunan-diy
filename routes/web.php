<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomRequestController;
use App\Http\Controllers\CustomerOrderController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiyRecipeController;
use App\Http\Controllers\Admin\DiyRecipeComponentController;
use App\Http\Controllers\Admin\DiyComponentOptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomRequestController as AdminCustomRequestController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

use App\Http\Controllers\Api\RuleRecommendationController;

// =========================
// PUBLIC / CUSTOMER AREA
// =========================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/projects/{id}', [HomeController::class, 'show']);

Route::get('/diy-projects', [DiyController::class, 'index'])
    ->name('diy.index');

Route::get('/catalog', [DiyController::class, 'index'])
    ->name('catalog.index');

Route::get('/diy-projects/{project}', [DiyController::class, 'showProject'])
    ->name('diy.project');

Route::get('/diy-recipes/{recipe}', [DiyController::class, 'showRecipe'])
    ->name('diy.recipe');

Route::post('/diy-recipes/{recipe}/calculate', [DiyController::class, 'calculate'])
    ->middleware('auth')
    ->name('diy.calculate');


// =========================
// AUTH / LOGIN
// =========================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// =========================
// Register Account
// =========================

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

// =========================
// CHECKOUT CUSTOMER
// =========================

Route::get('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/invoice/{order}', [CheckoutController::class, 'invoice'])
    ->name('checkout.invoice');





// =========================
// CUSTOMER ORDERS / PESANAN SAYA
// =========================

Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])
        ->name('customer.orders.index');

    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])
        ->name('customer.orders.show');

    Route::get('/custom-request', [CustomRequestController::class, 'create'])
        ->name('custom-requests.create');

    Route::post('/custom-request', [CustomRequestController::class, 'store'])
        ->name('custom-requests.store');

    Route::get('/custom-request/success/{customRequest}', [CustomRequestController::class, 'success'])
        ->name('custom-requests.success');
});


// =========================
// ADMIN AREA
// Semua route di sini wajib login dan role admin
// =========================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::resource('/projects', AdminProjectController::class)
            ->names('projects');

        Route::resource('/products', ProductController::class)
            ->names('products');

        Route::resource('/recipes', DiyRecipeController::class)
            ->names('recipes');

        // Kelola komponen resep
        Route::post('/recipes/{recipe}/components', [DiyRecipeComponentController::class, 'store'])
            ->name('recipe-components.store');

        Route::delete('/recipe-components/{component}', [DiyRecipeComponentController::class, 'destroy'])
            ->name('recipe-components.destroy');

        Route::post('/recipe-components/{component}/options', [DiyComponentOptionController::class, 'store'])
            ->name('component-options.store');

        Route::delete('/component-options/{option}', [DiyComponentOptionController::class, 'destroy'])
            ->name('component-options.destroy');

        // Pesanan
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.update-status');

        // Permintaan custom admin
        Route::get('/custom-requests', [AdminCustomRequestController::class, 'index'])
            ->name('custom-requests.index');

        Route::get('/custom-requests/{customRequest}', [AdminCustomRequestController::class, 'show'])
            ->name('custom-requests.show');

        Route::patch('/custom-requests/{customRequest}/status', [AdminCustomRequestController::class, 'updateStatus'])
            ->name('custom-requests.update-status');

        // POS Kasir
        Route::get('/pos', [PosController::class, 'index'])
            ->name('pos.index');

        Route::post('/pos', [PosController::class, 'store'])
            ->name('pos.store');

        // Laporan Penjualan
        Route::get('/reports/sales', [ReportController::class, 'sales'])
            ->name('reports.sales');
    });


// =================
// API AREA!!! (Rule-Based) :D
// =================

Route::get('/api/rule-recommendations', [RuleRecommendationController::class, 'show'])
    ->name('api.rule-recommendations');