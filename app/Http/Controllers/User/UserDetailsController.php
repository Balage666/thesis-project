<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserDetailsController extends Controller
{
    public function EditName(Request $request, User $user) {

        $editNameFormField = $request->validate([
            'name' => ['required', 'regex:/^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u']
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
}
