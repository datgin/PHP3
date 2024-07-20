<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomePageController;

use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/








Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        // dashboard routes
        Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

        // logout routes
        Route::get('logout', [HomeController::class, 'logout'])->name('admin.logout');

        // users routes
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('users/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');


        // products routes
        Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('products/destroy', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // categories routes
        Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('categories/update', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('categories/destroy', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Brands routes
        Route::get('brands', [BrandController::class, 'index'])->name('admin.brands.index');
        Route::get('brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('admin.brands.store');
        Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
        Route::put('brands/update', [BrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('brands/destroy', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

        // permissions routes
        Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::put('permissions/update', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('permissions/destroy', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

        // roles routes
        Route::get('roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    });
});

Route::get('/', [HomePageController::class, 'home'])->name('home');

// shop routes
Route::get('danhmuc/{slug?}', [ShopPageController::class, 'shop'])->name('shop');

// filter routes
Route::get('filter', [ShopPageController::class, 'filter'])->name('shop.filter');

// products-detail route

// cart routes
Route::get('gio-hang', [CartController::class, 'index'])->name('cartShow');
Route::post('add-to-cart', [CartController::class, 'store'])->name('cartAdd');
Route::post('xoa-gio-hang', [CartController::class, 'destroy'])->name('cartDestroy');
Route::post('cap-nhat-gio-hang', [CartController::class, 'update'])->name('cartUpdate');


Route::get('product/{slug}', [ProductDetailController::class, 'productDetail'])->name('product-detail');

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AccountController::class, 'login'])->name('login');
    Route::post('authenticate', [AccountController::class, 'authenticate'])->name('authenticate');

    Route::get('register', [AccountController::class, 'register'])->name('register');
    Route::post('pocess-register', [AccountController::class, 'pocessRegister'])->name('pocess-register');

    Route::get('verification-email/{email}', [AccountController::class, 'verificationEmail'])->name('verification-email');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AccountController::class, 'logout'])->name('logout');

    Route::get('profile', [AccountController::class, 'profile'])->name('profile');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::post('pocess-checkout', [CheckoutController::class, 'pocessCheckout'])->name('pocess-checkout');

    Route::get('thank-you', [CheckoutController::class, 'thankYou'])->name('thank-you');
});
