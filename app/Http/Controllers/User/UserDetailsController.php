<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Helper;

class UserDetailsController extends Controller
{
    public function EditName(Request $request, User $user) {

        $nameRegex = Helper::GetStrictNameRegex();

        $editNameFormField = $request->validate([
            'name' => ['required', "regex:$nameRegex"]
        ]);

        $oldName = $user->name;

        $user->name = $editNameFormField['name'];

        if ($oldName == $user->name) {
            return back()->with('message', 'Name stayed the same!');
        }

        $user->updated_at = now();
        $user->update();

        return redirect()->back()->with('message', 'Name modified!');

    }

    public function EditEmail(Request $request, User $user) {

        $editEmailFormField = $request->validate([
            'email' => ['required', 'email']
        ]);

        $rules = ['email' => 'unique:users,email'];

        $validator = Validator::make($editEmailFormField, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->onlyInput('email');
        }

        $oldEmail = $user->email;

        $user->email = $editEmailFormField['email'];

        // if ($oldEmail == $user->email) {
        //     return back()->with('message', 'Email stayed the same!');
        // }

        $user->updated_at = now();
        $user->update();

        return redirect()->back()->with('message', 'Email modified!');
    }

    //TODO: Implement reset password
    public function ResetPassword(Request $request, User $user) {

        $resetPassword = "ResetPassword";
        $user->password = $resetPassword;
        $user->updated_at = now();

        $user->update();

        return redirect()->back()->with('message', "Password has been reset for {$user->name}!");

    }

    public function ChangeProfilePicture(Request $request, User $user) {

        $oldPicture = $user->profile_picture;

        $profilePictureFormFields = $request->validate([
            'image' => ['required', 'mimes:jpeg,png,jpg']
        ]);
        $profilePictureFormFields['image'] = $request->file('image')->store('uploads/users/images', 'public');

        $profilePictureFormFields['image'] = "/storage/{$profilePictureFormFields['image']}";

        $temp = ltrim($oldPicture, '/storage/');

        if (file_exists(public_path("/storage/{$temp}"))) {
            unlink(public_path($oldPicture));
        }

        $user->profile_picture = $profilePictureFormFields['image'];

        $user->updated_at = now();

        $user->update();

        return redirect()->back()->with('message', "Profile picture has been changed for {$user->name}!");

    }
}
