<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClassListingController as AdminClassListingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ShopItemController as AdminShopItemController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('throttle:admin-login')->name('login.store');

    Route::post('/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');

        Route::resource('portfolio', AdminPortfolioController::class)->except(['show']);
        Route::resource('events', AdminEventController::class)->except(['show']);
        Route::resource('classes', AdminClassListingController::class)->except(['show'])->parameters([
            'classes' => 'classListing',
        ]);

        Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');

        Route::resource('shop', AdminShopItemController::class)->except(['show']);
    });
});

Route::get('/', HomeController::class)->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{artwork}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{artwork}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/shop/{artwork}/request', [ShopController::class, 'requestPurchase'])
    ->middleware('throttle:purchase')
    ->name('shop.request');

Route::get('/calendar', function (Request $request) {
    return redirect()->to(route('home').'#upcoming');
})->name('calendar');

Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('/classes/{classListing}', [ClassController::class, 'show'])->name('classes.show');
Route::post('/classes/{classListing}/signup', [ClassController::class, 'signup'])
    ->middleware('throttle:class-signup')
    ->name('classes.signup');

Route::view('/meet-the-owner', 'owner')->name('owner');

Route::get('/about', fn () => redirect()->to(route('home').'#about'))->name('about');
Route::get('/faq', fn () => redirect()->to(route('home').'#faq'))->name('faq');
Route::get('/contact', function (Request $request) {
    $type = $request->query('type');
    $query = [];
    if (is_string($type) && $type !== '') {
        $query['type'] = $type;
    }

    return redirect()->to(route('home', $query).'#contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.send');
