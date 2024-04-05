<?php

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callBackGoogle() {

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $createdGoogleUser = User::create([
                    'name' =>  $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'profile_picture' => $googleUser->getAvatar()
                ]);

                UserRole::create([
                    'name' => 'Customer',
                    'user_id' => $createdGoogleUser->id
                ]);

                Auth::login($createdGoogleUser);

                return redirect()->intended('storefront');
            }
            else {
                Auth::login($user);

                return redirect()->intended('storefront');
            }

        } catch (\Throwable $th) {
            abort(503, $th->getMessage());
        }

    }
}
