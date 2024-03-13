<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\UserRole;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $guest_cart = null;
        if (!auth()->check() && Session::has('cart_id')) {
            $guest_cart = Cart::find(Session::get('cart_id'))?->load(['CartItems']);
        }

        $elligible_for_dashboard = false;
        if (auth()->check()) {
            $roles = UserRole::where('user_id', '=', auth()->user()->id)->get();
            $elligible_for_dashboard = $roles->some(function ($role) {
                    return $role->name == 'Moderator' || $role->name == 'Seller' || $role->name == 'Admin';
            });
        }


        return array_merge(parent::share($request), [
            'flash' => [
                'message' => session('message')
            ],
            'active_session' => [
                'user' => auth()->user() ? auth()->user()->load([
                    'Roles', 'PhoneNumbers', 'Addresses', 'Products', 'ProductRatings', 'Cart'
                ]) : null,
                'auth_cart' => auth()->user() ? auth()->user()->load(['Cart'])->Cart?->load(['CartItems']) : null
            ],
            'permissions' => [
                'authenticated' => auth()->check(),
                'elligible_for_dashboard' => $elligible_for_dashboard
            ],
            'locales' => config('app.locales'),
            'current_locale' => Session::has('locale') ? Session::get('locale') : app()->currentLocale(),
            'guest_cart' => $guest_cart
        ]);
    }
}
