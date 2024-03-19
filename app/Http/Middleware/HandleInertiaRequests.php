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
        $has_customer_role = false;
        $has_admin_role = false;
        $has_moderator_role = false;
        $has_seller_role = false;
        $has_only_customer_role = false;
        $has_only_customer_role_and_seller_role = false;
        $has_moderator_role_at_most = false;

        if (auth()->check()) {

            $userWithRolesLoaded = auth()->user()->load(['Roles']);

            $elligible_for_dashboard = $userWithRolesLoaded->Roles->contains('name', 'Moderator')
                || $userWithRolesLoaded->Roles->contains('name', 'Seller')
                || $userWithRolesLoaded->Roles->contains('name', 'Admin');

            $has_admin_role = $userWithRolesLoaded->Roles->contains('name', 'Admin');
            $has_moderator_role = $userWithRolesLoaded->Roles->contains('name', 'Moderator');
            $has_seller_role = $userWithRolesLoaded->Roles->contains('name', 'Seller');
            $has_customer_role = $userWithRolesLoaded->Roles->contains('name', 'Customer');

            $has_only_customer_role = $userWithRolesLoaded->Roles->contains('name', 'Customer') &&
                                    $userWithRolesLoaded->Roles->count() == 1;

            $has_only_customer_role_and_seller_role = $userWithRolesLoaded->Roles->contains('name', 'Customer') &&
            $userWithRolesLoaded->Roles->contains('name', 'Seller') &&
            $userWithRolesLoaded->Roles->count() == 2;

            $has_moderator_role_at_most = $userWithRolesLoaded->Roles->contains('name', 'Moderator') &&
            !$userWithRolesLoaded->Roles->contains('name', 'Admin');
        }


        return array_merge(parent::share($request), [
            'flash' => [
                'message' => session('message')
            ],
            'active_session' => [
                'user' => auth()->user() ? auth()->user()->load([
                    'Roles', 'PhoneNumbers', 'Addresses', 'Products', 'ProductRatings', 'Cart', 'Favorites'
                ]) : null,
                'auth_cart' => auth()->user() ? auth()->user()->load(['Cart'])->Cart?->load(['CartItems']) : null
            ],
            'permissions' => [
                'authenticated' => auth()->check(),
                'elligible_for_dashboard' => $elligible_for_dashboard,
                'has_customer_role' => $has_customer_role,
                'has_admin_role' => $has_admin_role,
                'has_moderator_role' => $has_moderator_role,
                'has_moderator_role_at_most' => $has_moderator_role_at_most,
                'has_seller_role' => $has_seller_role,
                'has_only_customer_role' => $has_only_customer_role,
                'has_only_customer_role_and_seller_role' => $has_only_customer_role_and_seller_role,
            ],
            'locales' => config('app.locales'),
            'current_locale' => Session::has('locale') ? Session::get('locale') : app()->currentLocale(),
            'guest_cart' => $guest_cart
        ]);
    }
}
