<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCarouselResource;
use App\Http\Resources\Product\StorefrontProductResource;

class StoreFrontController extends Controller
{
    public function StoreFront(Request $request) {

        // dd($request);

        $selectedCategories = $request->get('selectedCategories');
        $selectedDistributors = $request->get('selectedDistributors');
        $rangeInput = $request->get('rangeInput');
        $availability = $request->get('availability');

        // dd($rangeInput, $availability, $selectedCategories, $selectedDistributors);
        $allProducts = Product::orderBy('created_at', 'desc')->get();

        if (!is_null($selectedCategories) && count($selectedCategories) != 0) {

            $allProducts = $allProducts->filter(function ($item) use($selectedCategories) {
                return in_array($item->Category->id, $selectedCategories);
            });
        }

        if (!is_null($selectedDistributors) && count($selectedDistributors) != 0) {
            $allProducts = $allProducts->filter(function ($item) use($selectedDistributors) {
                return in_array($item->Distributor->id, $selectedDistributors);
            });
        }

        if (!is_null($rangeInput) && count($rangeInput) != 0) {
            $allProducts = $allProducts->filter(function ($item) use ($rangeInput) {

                return $item->price >= $rangeInput[0] && $item->price <= $rangeInput[1];

            });
        }

        if (!is_null($availability) && $availability) {
            $allProducts = $allProducts->filter(function ($item) {

                return $item->stock > 0;

            });
        }

        // dd($allProducts, $selectedCategories, $selectedDistributors);

        $cateogories = Category::all();

        $distributors = User::all();

        $carouselProducts = Product::where('stock', '>', 20)->inRandomOrder()->limit(15)->get();

        if ($allProducts->isNotEmpty()) {
            $allProducts = $allProducts->toQuery()->paginate(6)->withQueryString();
        }


        if ($request->wantsJson()) {
            return StorefrontProductResource::collection($allProducts);
        }

        return Inertia::render("Storefront", [
            'allProducts' => StorefrontProductResource::collection($allProducts),
            'carouselProducts' => ProductCarouselResource::collection($carouselProducts),
            'categories' => $cateogories,
            'distributors' => $distributors
        ]);
    }
}
