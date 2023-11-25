<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function LogIn() {

        return view('auth.login');

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

        return redirect('/');
    }



    public function SignUp() {

        return view('auth.sigup');

    }
}
