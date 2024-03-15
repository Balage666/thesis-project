<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Helper;


class UserController extends Controller
{
    private $nameRegex;
    private $passwordRegex;

    public function __construct() {

        $this->nameRegex = Helper::GetStrictNameRegex();
        $this->passwordRegex = Helper::GetPasswordRegex();
    }

    /**
     * Display a listing of the resource.
     */
    public function List()
    {
        return Inertia::render("User/List",
            ['users' => UserResource::collection( User::all() )]
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
            'name' => ['required', "regex:$this->nameRegex"],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', "regex:$this->passwordRegex"],
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

        return redirect()->route('user-show', [ "user" => $createUser ])->with('message', 'User created!');

    }

    /**
     * Display the specified resource.
     */
    public function Show(User $user)
    {
        return Inertia::render("User/Show", [
            'userToShow' => UserResource::collection(User::where('id', $user->id)->get())
        ]);
    }

    public function Profile(User $user) {

        // $this->authorizeForUser(auth()->user(), 'profile', [$user]);

        return Inertia::render("User/Profile", [
            'user' => UserResource::collection(User::where('id', $user->id)->get())
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     * Legacy Edit Form page
     */
    public function Edit(User $user)
    {
        $this->authorizeForUser(auth()->user(), 'legacyEdit', [$user]);

        // $foundUser = User::where('id', $user->id)->with(['Roles', 'PhoneNumbers', 'Addresses', 'Products'])->get();

        return Inertia::render("User/LegacyEdit", [
            'userToEdit' => UserResource::collection(User::where('id', $user->id)->get())
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Logic behind Legacy Edit
     */
    public function Update(UpdateUserRequest $request, User $user)
    {
        // dd($request, $user, $user->Roles());

        $validated = $request->validated();

        $updateUserFormFields = $validated;

        // $updateUserFormFields = $request->validate([
        //     'name' => ['required', "regex:$this->nameRegex"],
        //     'email' => ['required', 'email'],
        //     'roles' => ['required', 'min:1']
        // ]);

        // $rules = ['email' => 'unique:users,email'];

        // $validator = Validator::make($updateUserFormFields, $rules);

        // if ($validator->fails()) {
        //     return back()->withErrors($validator->errors())->onlyInput('name');
        // }

        $user->name = $updateUserFormFields['name'];
        $user->email = $updateUserFormFields['email'];
        $user->updated_at = now();

        $roles = $updateUserFormFields['roles'];

        // dd($roles);

        $user->update();

        UserRole::where([['user_id', '=', $user->id], ['name', '!=', 'Customer']])->delete();
        foreach ($roles as $role) {
            UserRole::create([
                'name' => $role,
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('user-show', ['user' => $user])->with('message', 'User update succeeded!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy(User $user)
    {
        // dd($user);
        if (auth()->user()->id === $user->id) {
            return redirect()->route('user-list')->withErrors(['delete' => 'User self-deletion prevented!']);
        }

        if (auth()->user()->Roles->contains('name', 'Moderator') && $user->Roles->contains('name', 'Admin')) {
            return redirect()->route('user-list')->withErrors(['delete' => 'Cannot delete Admin as Moderator']);
        }

        if (auth()->user()->Roles->contains('name', 'Moderator') && $user->Roles->contains('name', 'Moderator')) {
            return redirect()->route('user-list')->withErrors(['delete' => 'Cannot delete other Moderators as Moderator']);
        }

        $user->delete();

        return redirect()->route('user-list')->with('message', 'User deleted');
    }
}
