<?php

use App\Http\Controllers\User\AuthController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\Socialite\GoogleAuthController;
use App\Http\Controllers\Localization\LanguageSwitcherController;
use App\Http\Controllers\Phone\PhoneController;
use App\Http\Controllers\User\UserDetailsController;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SetLocalizationMiddleware;

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

    //DONE: Create a working middleware for these routes
    //and not an anomaly which makes the devserver shit itself :)
    Route::group(['prefix' => 'user-management', 'middleware' => 'role:Moderator,Admin'], function () {
        Route::get('create', [UserController::class, 'Create'])->name('user-create');
        Route::get('list', [UserController::class, 'List'])->name('user-list');
        Route::get('show/{user}', [UserController::class, 'Show'])->name('user-show');
        Route::get('edit/{user}', [UserController::class, 'Edit'])->name('user-edit');

        Route::post('store', [UserController::class, 'Store'])->name('user-store');
        Route::post('edit/{user}', [UserController::class, 'Update'])->name('user-update');

        Route::get('delete/{user}', [UserController::class, 'Destroy'])->name('user-delete');

        Route::post('edit-name/{user}', [UserDetailsController::class, 'EditName'])->name('user-name-edit');
        Route::post('edit-email/{user}', [UserDetailsController::class, 'EditEmail'])->name('user-email-edit');
        Route::post('reset-password/{user}', [UserDetailsController::class, 'ResetPassword'])->name('user-reset-password');

        Route::post('phone-add/{user}', [PhoneController::class, 'Store'])->name('phone-number-add');
    });

    Route::get('/', function() {
        return redirect()->route('storefront');
    })->withoutMiddleware('auth');

    Route::get('/storefront', [StoreFrontController::class, 'Storefront'])->name('storefront')->withoutMiddleware('auth');

    Route::get('/set-language/{language}', [LanguageSwitcherController::class, 'setLanguage'])->name('switch-language')->withoutMiddleware('auth');

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
