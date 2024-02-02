<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class StoreFrontController extends Controller
{
    public function StoreFront() {


        // dd(User::find(1)->id);
        // return view('storefront.welcome');
        return Inertia::render("Home");
    }
}
