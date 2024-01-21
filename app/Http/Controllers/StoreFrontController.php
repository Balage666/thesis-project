<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreFrontController extends Controller
{
    public function StoreFront() {

        // return view('storefront.welcome');
        return Inertia::render("Home");
    }
}
