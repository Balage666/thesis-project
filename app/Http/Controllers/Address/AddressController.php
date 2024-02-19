<?php

namespace App\Http\Controllers\Address;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function Store(Request $request, User $user) {


        $addressFormFields = $request->validate([
            // ...
        ]);

        Address::create([
            // ...
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('message', 'Address created!');

    }
}
