<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
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
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/log-in');
    }



    public function SignUp() {

        return Inertia::render("Auth/SignUp");

    }

    public function SignOn(Request $request) {

        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:3', 'regex:/^[A-Z][a-z]+\s[a-zA-Z\s\.]+/'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
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

        return Inertia::render("Auth/LogIn")->with("registration_success", "Successfully registered!");
    }
}
