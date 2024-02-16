<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserDetailsController extends Controller
{
    public function EditName(Request $request, User $user) {

        $editNameFormField = $request->validate([
            'name' => ['required', 'regex:/^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u']
        ]);

        $user->name = $editNameFormField['name'];
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
    }

    //TODO: Implement reset password
    public function ResetPassword() {

    }
}
