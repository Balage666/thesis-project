<?php

use App\Http\Controllers\StoreFrontController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('storefront');
});

Route::get('/storefront', [StoreFrontController::class, 'Storefront'])->name('storefront');

Route::get('/auth/log-in', [UserController::class, 'LogIn']);
Route::post('/auth/log-on', [UserController::class, 'LogOn']);

Route::get('/auth/log-out', [UserController::class, 'LogOut']);

Route::get('/auth/sign-up', [UserController::class, 'SignUp']);
Route::post('/auth/sign-on', [UserController::class, 'SignOn']);


// Route::post('/auth/login', );
