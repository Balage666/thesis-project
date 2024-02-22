<?php

namespace App\Http\Controllers\Address;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Axlon\PostalCodeValidation\Rules\PostalCode;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function Store(Request $request, User $user) {

        // dd($request['countryIso']);

        $addressFormFields = $request->validate([
            'countryIso' => ['required', 'max:2'],
            'regionIso' => ['required'],
            'postalZipCode' => ['required'],
            'addressText' => ['required']
        ]);

        $rules = ['postalZipCode' => PostalCode::for($addressFormFields['countryIso'])];

        $validator = Validator::make($addressFormFields, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        // dd($addressFormFields);

        Address::create([
            'country' => $addressFormFields['countryIso'],
            'postal_or_zip_code' => $addressFormFields['postalZipCode'],
            'state_or_region' => $addressFormFields['regionIso'],
            'address_text' => $addressFormFields['addressText'],
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('message', 'Address created!');

    }
}
