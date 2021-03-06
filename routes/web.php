<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;

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
Route::redirect('/', 'home');

Route::get('/language/{locale}', [LangController::class, 'switchLang'])->name('lang');

Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])->name('delete.image');
    });
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/shop', [UserProductController::class, 'showByRating'])->name('shop');
    Route::get('/shop/{id}/detail', [UserProductController::class, 'showDetails'])->name('shop.detail');
    Route::get('brand/{id}', [UserProductController::class, 'showByBrand'])->name('brand');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::get('add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::get('remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('clear', [CartController::class, 'clear'])->name('cart.clear');
    });
    Route::post('/comment/{product_id}', [CommentController::class, 'comment'])->name('comment');
    Route::put('/comment/update/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/destroy/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/cart/checkout', [OrderController::class, 'infoOrder'])->name('checkout');
    Route::post('/placeorder', [OrderController::class, 'postOrder'])->name('placeorder');
    Route::get('/history', [OrderController::class, 'historyOrder'])->name('user.history');
    Route::get('/history/{id}/detail', [OrderController::class, 'showOrderDetail'])->name('user.history.detail');
    Route::put('/updatestatus/{id}', [OrderController::class, 'updatestatus'])->name('user.updatestatus');
    Route::get('mark-at-read/{order_id}/{id}', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::get('mark-at-read-all', [NotificationController::class, 'markAsReadAll'])->name('mark-as-read-all');
});
