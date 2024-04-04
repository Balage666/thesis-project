<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\User;
use Inertia\Inertia;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\UpdateUserRequest;


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
    public function List(Request $request)
    {
        $usersList = User::orderBy('created_at', 'desc')->paginate(8);

        if ($request->get('search')) {
            $search = $request->get('search');

            $usersList = User::where('name', 'LIKE', "%$search%")
            ->orWhereHas('Roles', function ($query) use($search) {
                $roleSearch = ucfirst($search);
                $query->where('name', 'LIKE', "%$roleSearch%");
            })->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
        }

        if ($request->wantsJson()) {
            return UserResource::collection( $usersList );
        }

        return Inertia::render("User/List",
            ['users' => UserResource::collection( $usersList )]
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
        $createUserFormFields = $request->validate([
            'name' => ['required', "regex:$this->nameRegex"],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', "regex:$this->passwordRegex"],
            'roles' => ['required', 'min:1']
        ]);

        $rules = ['email' => 'unique:users,email'];

        $validator = Validator::make($createUserFormFields, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->onlyInput('name');
        }

        $tempName = $createUserFormFields["name"];

        $tempNameParts = explode(" ", $tempName);

        $roles = $createUserFormFields['roles'];

        $createUser = User::create([
            'name' => $tempName,
            'email' => $createUserFormFields['email'],
            'password' => $createUserFormFields['password'],
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name={$tempNameParts[0]}+{$tempNameParts[1]}",
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

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

    /**
     * Show the form for editing the specified resource.
     * Legacy Edit Form page
     */
    public function Edit(User $user)
    {
        $this->authorizeForUser(auth()->user(), 'legacyEdit', [$user]);

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
        $validated = $request->validated();

        $updateUserFormFields = $validated;

        $user->name = $updateUserFormFields['name'];
        $user->email = $updateUserFormFields['email'];
        $user->updated_at = now();

        $roles = $updateUserFormFields['roles'];

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
