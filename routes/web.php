<?php

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\Phone\PhoneController;
use App\Http\Resources\Product\ProductResource;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\User\UserDetailsController;
use App\Http\Controllers\Socialite\GoogleAuthController;
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
        Route::get('delete/{user}', [UserController::class, 'Destroy'])->name('user-delete');

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
