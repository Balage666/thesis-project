<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Shared\ValidationHelper;
use Helper;

class AuthController extends Controller
{
    public function LogIn() {

        return Inertia::render("Auth/LogIn");
    }

    public function LogOn(Request $request) {


        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($formFields)) {

            $request->session()->regenerate();

            return redirect('/')->with('message', 'Sign in succeeded!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');

    }

    public function LogOut(Request $request)
    {
        auth()->logout();

        $saved_locale = $request->session()->get('locale');
        // dd($request->session()->get('locale'));
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($saved_locale != null) {
            $request->session()->put('locale', $saved_locale);
        }

        return redirect()->route('log-in');
    }



    public function SignUp() {

        return Inertia::render("Auth/SignUp");

    }

    public function SignOn(Request $request) {

        $nameRegex = Helper::GetStrictNameRegex();
        $passwordRegex = Helper::GetPasswordRegex();

        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:3', "regex:$nameRegex"],
            'password' => ['required', 'confirmed', 'min:8', "regex:$passwordRegex"],
        ]);


        $rules = ['email' => 'unique:users,email'];

        $validator = Validator::make($formFields, $rules);

        if ($validator->fails()) {
            return back()->withErrors(['email' => 'Invalid email'])->onlyInput('email');
        }

        $tempName = $formFields["name"];

        $tempNameParts = explode(" ", $tempName);

        $user = User::create([
            "email" => $formFields["email"],
            "name" => $tempName,
            "password" => $formFields["password"],
            "profile_picture" => "https://ui-avatars.com/api/?size=256&background=random&name={$tempNameParts[0]}+{$tempNameParts[1]}",
            "remember_token" => Str::random(10)
        ]);
        $user->Roles()->save(\App\Models\UserRole::create([
            'name' => 'Customer',
            'user_id' => $user->id
        ]));

        return redirect()->route('log-in')->with("registration_success", "Successfully registered!");
    }
}
