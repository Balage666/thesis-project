<?php

use App\Http\Controllers\Socialite\GoogleAuthController;
use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function() {
    return redirect()->route('storefront');
});

Route::get('/storefront', [StoreFrontController::class, 'Storefront'])->name('storefront');

Route::get('/auth/log-in', [UserController::class, 'LogIn'])->name('log-in');
Route::post('/auth/log-on', [UserController::class, 'LogOn'])->name('log-on');

Route::get('/auth/google-log-in', [GoogleAuthController::class, 'redirect'])->name('google-log-in');
Route::get('/auth/google-log-on', [GoogleAuthController::class, 'callBackGoogle'])->name('google-log-on');

Route::get('/auth/log-out', [UserController::class, 'LogOut'])->name('log-out');

Route::get('/auth/sign-up', [UserController::class, 'SignUp'])->name('sign-up');
Route::post('/auth/sign-on', [UserController::class, 'SignOn'])->name('sign-on');
