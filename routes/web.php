<?php

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Phone\PhoneController;
use App\Http\Resources\Product\ProductResource;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserDetailsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Socialite\GoogleAuthController;
use App\Http\Controllers\Product\ProductDetailsController;
use App\Http\Controllers\Localization\LanguageSwitcherController;

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
Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'dashboard', 'middleware' => 'role:Seller,Moderator,Admin'], function () {

        Route::get('main', [DashboardController::class, 'Main'])->name('dashboard-main');

    });

    Route::group(['prefix' => 'user-management', 'middleware' => 'role:Moderator,Admin'], function () {

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
         */
        Route::get('create', [UserController::class, 'Create'])->name('user-create');
        Route::get('list', [UserController::class, 'List'])->name('user-list');
        Route::get('show/{user}', [UserController::class, 'Show'])->name('user-show');
        Route::get('edit/{user}', [UserController::class, 'Edit'])->name('user-edit');
        Route::post('store', [UserController::class, 'Store'])->name('user-store');
        Route::post('edit/{user}', [UserController::class, 'Update'])->name('user-update');
        Route::post('delete/{user}', [UserController::class, 'Destroy'])->name('user-delete');

        /*
        |--------------------------------------------------------------------------
        | UserDetails Routes
        |--------------------------------------------------------------------------
         */
        Route::post('edit-name/{user}', [UserDetailsController::class, 'EditName'])->name('user-name-edit');
        Route::post('edit-email/{user}', [UserDetailsController::class, 'EditEmail'])->name('user-email-edit');
        Route::post('reset-password/{user}', [UserDetailsController::class, 'ResetPassword'])->name('user-reset-password');
        Route::post('change-profile-picture/{user}', [UserDetailsController::class, 'ChangeProfilePicture'])->name('user-change-profile-picture');

        /*
        |--------------------------------------------------------------------------
        | PhoneNumber Routes
        |--------------------------------------------------------------------------
         */
        Route::post('phone-add/{user}', [PhoneController::class, 'Store'])->name('phone-number-add');
        Route::post('phone-edit/{phone}', [PhoneController::class, 'Update'])->name('phone-number-update');
        Route::get('phone-delete/{phone}', [PhoneController::class, 'Delete'])->name('phone-number-delete');

        /*
        |--------------------------------------------------------------------------
        | Address Routes
        |--------------------------------------------------------------------------
         */
        Route::post('address-add/{user}', [AddressController::class, 'Store'])->name('address-create');
        Route::get('address-delete/{address}', [AddressController::class, 'Delete'])->name('address-delete');

    });

    Route::group(['prefix' => 'product-management', 'middleware' => 'role:Seller,Admin'], function () {

        /*
        |--------------------------------------------------------------------------
        | Product Routes
        |--------------------------------------------------------------------------
         */
        Route::get('create', [ProductController::class, 'Create'])->name('product-create');
        Route::post('store', [ProductController::class, 'Store'])->name('product-store');
        Route::get('list', [ProductController::class, 'List'])->name('product-list');
        Route::get('show/{product}', [ProductController::class, 'Show'])->name('product-show');
        Route::get('edit/{product}', [ProductController::class, 'Edit'])->name('product-edit');
        Route::post('edit/{product}', [ProductController::class, 'Update'])->name('product-update');
        Route::get('delete/{product}', [ProductController::class, 'Destroy'])->name('product-delete');

        /*
        |--------------------------------------------------------------------------
        | ProductDetails Routes
        |--------------------------------------------------------------------------
         */
        Route::post('rating/{product}/add', [ProductDetailsController::class, 'AddRating'])->name('product-rate');

    });

    Route::group(['prefix' => 'shopping-basket'], function () {

        Route::post(
            'add/{product}', [CartController::class, 'AddToCart']
        )->name('add-to-basket')->withoutMiddleware('auth');

        Route::post(
            'remove/{product}', [CartController::class, 'RemoveFromCart']
        )->name('remove-from-basket')->withoutMiddleware('auth');

        Route::post('clear', [CartController::class, 'ClearCart'])->name('clear-basket')->withoutMiddleware('auth');
    });

    Route::group(['prefix' => 'order-management'], function() {

        Route::get('{user}/list', [OrderController::class, 'List'])->name('user-order');
        Route::get('list/all', [OrderController::class, 'AllList'])->name('all-orders');
        Route::get('order/{cart}/create', [OrderController::class, 'Create'])->name('order-create')->withoutMiddleware('auth');
        Route::post('order/{cart}/create', [OrderController::class, 'Store'])->name('order-store')->withoutMiddleware('auth');
        Route::get('order/{order}/edit', [OrderController::class, 'Edit'])->name('order-edit');
        Route::post('order/{order}/edit', [OrderController::class, 'Update'])->name('order-update');
        Route::post('order/{order}/delete', [OrderController::class, 'Destroy'])->name('order-destroy')->withoutMiddleware('auth');

    });

    Route::get('/', function() {
        return redirect()->route('storefront');
    })->withoutMiddleware('auth');

    Route::get('/storefront', [StoreFrontController::class, 'Storefront'])->name('storefront')->withoutMiddleware('auth');

    Route::get('/set-language/{language}', [LanguageSwitcherController::class, 'setLanguage'])->name('switch-language')->withoutMiddleware('auth');

    Route::group(['prefix' => 'users'], function () {
        Route::get('profile/{user}', [UserController::class, 'Profile'])->name('user-profile');
    });

});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {

    Route::get('log-in', [AuthController::class, 'LogIn'])->name('log-in');
    Route::post('log-on', [AuthController::class, 'LogOn'])->name('log-on');

    Route::get('google-log-in', [GoogleAuthController::class, 'redirect'])->name('google-log-in');
    Route::get('google-log-on', [GoogleAuthController::class, 'callBackGoogle'])->name('google-log-on');

    Route::get('log-out', [AuthController::class, 'LogOut'])->name('log-out')->withoutMiddleware('guest');

    Route::get('sign-up', [AuthController::class, 'SignUp'])->name('sign-up');
    Route::post('sign-on', [AuthController::class, 'SignOn'])->name('sign-on');
});

Route::get('/new-feature-test', function () {
    // dd(ProductResource::collection(Product::all()));
    return Inertia::render("Test", ['products' => ProductResource::collection( Product::all() ) ]);
})->name('feature-test');
