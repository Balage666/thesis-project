<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\User\UserResource;
use App\Models\Product;

class DashboardController extends Controller
{
    public function Main() {

        return Inertia::render("Dashboard/Main");

    }

    public function Charts() {

        $allUsers = User::all();
        $allCategories = Category::all();
        $allProducts = Product::all();

        return Inertia::render("Dashboard/Chart", [
            'allUsers' => UserResource::collection($allUsers),
            'allCategories' => CategoryResource::collection($allCategories),
            'allProducts' => ProductResource::collection($allProducts)
        ]);

    }
}
