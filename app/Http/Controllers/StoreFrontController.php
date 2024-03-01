<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class StoreFrontController extends Controller
{
    public function StoreFront() {

        return Inertia::render("Storefront");
    }
}
