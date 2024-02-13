<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function List()
    {
        return Inertia::render("User/List");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        return Inertia::render("User/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        // dd($request);

        $createUserFormFields = $request->validate([
            'name' => ['required', 'regex:/^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'roles' => ['required', 'min:1']
        ]);

        // dd($createUserFormFields);

        $rules = ['email' => 'unique:users,email'];

        $validator = Validator::make($createUserFormFields, $rules);

        // dd($validator->fails());

        if ($validator->fails()) {
            return back()->withErrors(['name' => 'Invalid credentials'])->onlyInput('name');
        }

    }

    /**
     * Display the specified resource.
     */
    public function Show(User $user)
    {
        return Inertia::render("User/Show");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy(User $user)
    {
        //
    }
}
