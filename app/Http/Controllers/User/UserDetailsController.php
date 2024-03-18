<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Mail\User\GrantSellerRoleMail;
use App\Mail\User\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

        if ($oldEmail == $user->email) {
            return back()->with('message', 'Email stayed the same!');
        }

        $user->updated_at = now();
        $user->update();

        return redirect()->back()->with('message', 'Email modified!');
    }

    //TODO: Implement reset password
    public function ResetPassword(Request $request, User $user) {

        $passwordRegex = Helper::GetPasswordRegex();

        $resetPassword = fake()->regexify($passwordRegex);
        $user->password = $resetPassword;
        $user->updated_at = now();

        $user->update();

        $title = 'Email testing from BlueVenue';
        $body = "Your password has been reset! Here is your new one: $resetPassword";

        Mail::to(env("MAIL_USERNAME"))->send(new ResetPasswordMail($title, $body));

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

    public function GrantSellerRole(Request $request, User $user) {

        $newRole = UserRole::newModelInstance([
            'name' => 'Seller'
        ]);


        $user->Roles()->save($newRole);

        $title = 'Email testing from BlueVenue';
        $body = "The following role: $newRole->name has been granted to you, $user->name!";

        Mail::to(env("MAIL_USERNAME"))->send(new GrantSellerRoleMail($title, $body));

        return redirect()->back()->with('message', 'Email sent!');
    }
}
