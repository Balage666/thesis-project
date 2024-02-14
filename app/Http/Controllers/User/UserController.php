<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRole;
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
        return Inertia::render("User/List",
            ['users' => UserResource::collection( User::paginate(10) )]
        );
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
            // dd($validator->errors());
            return back()->withErrors($validator->errors())->onlyInput('name');
        }

        $tempName = $createUserFormFields["name"];

        $tempNameParts = explode(" ", $tempName);

        $roles = $createUserFormFields['roles'];

        $createUser = User::create([
            'name' => $tempName,
            'email' => $createUserFormFields['email'],
            'password' => $createUserFormFields['password'],
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name={$tempNameParts[0]}+{$tempNameParts[1]}"
        ]);

        // dd($createUser->id);

        foreach ($roles as $role) {
            UserRole::create([
                'name' => $role,
                'user_id' => $createUser->id
            ]);
        }

        return redirect()->route('storefront');

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
