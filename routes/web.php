<?php

use App\Http\Controllers\User\AuthController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\Socialite\GoogleAuthController;
use App\Http\Controllers\Localization\LanguageSwitcherController;
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
Route::group(['middleware' => ['localization', 'inertia']], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'user-management'], function () {
            Route::get('create', [UserController::class, 'Create'])->name('user-create');
            Route::get('list', [UserController::class, 'List'])->name('user-list');
            Route::get('show', [UserController::class, 'Show'])->name('user-show');

            Route::post('store', [UserController::class, 'Store'])->name('user-store');
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

});
