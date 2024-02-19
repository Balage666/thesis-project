<?php

namespace App\Http\Controllers\Phone;

use App\Models\User;
use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhoneController extends Controller
{
    public function Store(Request $request, User $user) {

        $phoneNumberFormFields = $request->validate([
            'number' => ['required', 'unique:phones,number'],
            'mask' => ['required']
        ]);

        Phone::create([
            'number' => $phoneNumberFormFields['number'],
            'mask' => $phoneNumberFormFields['mask'],
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('message', 'Phone number added!');

    }
}
