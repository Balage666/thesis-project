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
            'countryIso' => ['required'],
            'number' => ['required'],
            'mask' => ['required']
        ]);

        Phone::create([
            'countryIso2code' => $phoneNumberFormFields['countryIso'],
            'number' => $phoneNumberFormFields['number'],
            'mask' => $phoneNumberFormFields['mask'],
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('message', 'Phone number added!');

    }

    public function Update(Request $request, Phone $phone) {

        $editedPhoneNumberFormField = $request->validate([
            'number' => ['required', 'unique:phones,number']
        ]);

        $phone->number = $editedPhoneNumberFormField['number'];
        $phone->updated_at = now();

        $phone->update();

        return redirect()->back()->with('message', 'Phone number modifed!');
    }

    public function Delete(Phone $phone) {

        $phone->delete();

        return redirect()->back()->with('message', 'Phone number deleted!');

    }
}
