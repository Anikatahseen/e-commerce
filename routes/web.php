<?php

use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\HomeComponet;
use App\Http\Livewire\ShopComponet;
use App\Http\Livewire\CheckoutComponet;
use App\Http\Livewire\CartComponet;
use App\Http\Livewire\CatagoryComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',HomeComponet::class)->name('home.index');

Route::get('/shop',ShopComponet::class)->name('shop');

Route::get('/product/{slug}',DetailsComponent::class)->name('product.details');

Route::get('/cart',CartComponet::class)->name('shop.cart');

Route::get('/checkout',CheckoutComponet::class)->name('shop.checkout');

Route::get('/product-category/{slug}',CatagoryComponent::class)->name('product.category');

Route::get('/search',SearchComponent::class)->name('product.search');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function(){
    Route::get('/user/dashboard', UserDashboardComponent::class)->name('user.dashboard');
});

Route::middleware(['auth','authadmin'])->group(function(){
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
});

require __DIR__.'/auth.php';

