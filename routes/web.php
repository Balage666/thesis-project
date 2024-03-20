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
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Socialite\GoogleAuthController;
use App\Http\Controllers\Product\ProductDetailsController;
use App\Http\Controllers\Localization\LanguageSwitcherController;
use App\Http\Middleware\RoleMiddleware;

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
        Route::get('charts', [DashboardController::class, 'Charts'])->name('dashboard-charts');

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
        Route::post('edit-name/{user}', [UserDetailsController::class, 'EditName'])->name('user-name-edit')->withoutMiddleware('role:Moderator,Admin');
        Route::post('edit-email/{user}', [UserDetailsController::class, 'EditEmail'])->name('user-email-edit')->withoutMiddleware('role:Moderator,Admin');
        Route::post('reset-password/{user}', [UserDetailsController::class, 'ResetPassword'])->name('user-reset-password')->withoutMiddleware('role:Moderator,Admin');
        Route::post('change-profile-picture/{user}', [UserDetailsController::class, 'ChangeProfilePicture'])->name('user-change-profile-picture')->withoutMiddleware('role:Moderator,Admin');
        Route::post('grant-seller-role/{user}', [UserDetailsController::class, 'GrantSellerRole'])->name('seller-role-grant')->withoutMiddleware('role:Moderator,Admin');

        /*
        |--------------------------------------------------------------------------
        | PhoneNumber Routes
        |--------------------------------------------------------------------------
         */
        Route::post('phone-add/{user}', [PhoneController::class, 'Store'])->name('phone-number-add')->withoutMiddleware('role:Moderator,Admin');
        Route::post('phone-edit/{phone}', [PhoneController::class, 'Update'])->name('phone-number-update')->withoutMiddleware('role:Moderator,Admin');
        Route::post('phone-delete/{phone}', [PhoneController::class, 'Delete'])->name('phone-number-delete')->withoutMiddleware('role:Moderator,Admin');

        /*
        |--------------------------------------------------------------------------
        | Address Routes
        |--------------------------------------------------------------------------
         */
        Route::post('address-add/{user}', [AddressController::class, 'Store'])->name('address-create')->withoutMiddleware('role:Moderator,Admin');
        Route::post('address-delete/{address}', [AddressController::class, 'Delete'])->name('address-delete')->withoutMiddleware('role:Moderator,Admin');

        /*
        |--------------------------------------------------------------------------
        | Favorite Routes
        |--------------------------------------------------------------------------
         */
        Route::post('add-product-to-favorites/{user}/{product}', [FavoriteController::class, 'AddToFavorites'])->name('add-to-favorites')->withoutMiddleware('role:Moderator,Admin');
        Route::post('remove-from-favorites/{user}/{product}', [FavoriteController::class, 'RemoveFromFavorites'])->name('remove-from-favorites')->withoutMiddleware('role:Moderator,Admin');
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
        Route::get('show/{product}', [ProductController::class, 'Show'])->name('product-show')->withoutMiddleware('auth')->withoutMiddleware('role:Seller,Admin');
        Route::get('edit/{product}', [ProductController::class, 'Edit'])->name('product-edit');
        Route::post('edit/{product}', [ProductController::class, 'Update'])->name('product-update');
        Route::post('delete/{product}', [ProductController::class, 'Destroy'])->name('product-delete');

        /*
        |--------------------------------------------------------------------------
        | ProductDetails Routes
        |--------------------------------------------------------------------------
         */
        Route::post('rating-add/{product}', [ProductDetailsController::class, 'AddRating'])->name('rate-add')->withoutMiddleware('role:Seller,Admin');
        Route::post('rating-delete/{product}', [ProductDetailsController::class, 'DeleteRating'])->name('rate-destroy')->withoutMiddleware('role:Seller,Admin');
        Route::post('comment-add/{product}', [ProductDetailsController::class, 'AddComment'])->name('comment-add')->withoutMiddleware('role:Seller,Admin');
        Route::post('comment-delete/{comment}', [ProductDetailsController::class, 'DeleteComment'])->name('comment-destroy')->withoutMiddleware('role:Seller,Admin');

        Route::post('change-name/{product}', [ProductDetailsController::class, 'ChangeProductName'])->name('product-name-change');
        Route::post('change-description/{product}', [ProductDetailsController::class, 'ChangeProductDescription'])->name('product-description-change');
        Route::post('change-price/{product}', [ProductDetailsController::class, 'ChangeProductPrice'])->name('product-price-change');
        Route::post('change-stock-value/{product}', [ProductDetailsController::class, 'ChangeProductStockValue'])->name('product-stock-change');

        Route::post('upload-pictures/{product}', [ProductDetailsController::class, 'UploadProductPictures'])->name('product-pictures-upload');
        Route::post('delete-pictures/{product}', [ProductDetailsController::class, 'DeleteProductPictures'])->name('product-pictures-delete');

    });

    Route::group(['prefix' => 'category-management', 'middleware' => 'role:Seller,Admin'], function () {

        Route::get('list', [CategoryController::class, 'List'])->name('category-list');
        Route::post('store', [CategoryController::class, 'Store'])->name('category-store');
        Route::post('delete/{category}', [CategoryController::class, 'Destroy'])->name('category-delete');
    });

    Route::group(['prefix' => 'shopping-basket'], function () {

        Route::get(
            'list', [CartController::class, 'List']
        )->name('basket-list')->withoutMiddleware('auth');

        Route::post(
            'add/{product}', [CartController::class, 'AddToCart']
        )->name('add-to-basket')->withoutMiddleware('auth');

        Route::post(
            'remove/{product}', [CartController::class, 'RemoveFromCart']
        )->name('remove-from-basket')->withoutMiddleware('auth');

        Route::post(
            'increment/{product}', [CartController::class, 'Increment']
        )->name('basket-increment')->withoutMiddleware('auth');

        Route::post(
            'decrement/{product}', [CartController::class, 'Decrement']
        )->name('basket-decrement')->withoutMiddleware('auth');

        Route::post(
            'clear', [CartController::class, 'ClearCart']
        )->name('clear-basket')->withoutMiddleware('auth');
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
        Route::get('profile/{user}', [UserController::class, 'Show'])->name('user-profile');
    });

});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {

    Route::get('log-in', [AuthController::class, 'LogIn'])->name('log-in');
    Route::post('log-on', [AuthController::class, 'LogOn'])->name('log-on');

    Route::get('google-log-in', [GoogleAuthController::class, 'redirect'])->name('google-log-in');
    Route::get('google-log-on', [GoogleAuthController::class, 'callBackGoogle'])->name('google-log-on');

    Route::get('log-out', [AuthController::class, 'LogOut'])->name('log-out')->withoutMiddleware('guest');

    Route::get('sign-up', [AuthController::class, 'SignUp'])->name('sign-up');
    Route::post('sign-on', [AuthController::class, 'ImprovedSignOn'])->name('sign-on');
});

Route::get('/new-feature-test', function () {
    // dd(ProductResource::collection(Product::all()));
    return Inertia::render("Test", ['products' => ProductResource::collection( Product::all() ) ]);
})->name('feature-test');
