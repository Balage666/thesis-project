<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductCarouselResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\StorefrontProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreFrontController extends Controller
{
    public function StoreFront(Request $request) {


        $carouselProducts = Product::where('stock', '>', 20)->inRandomOrder()->limit(15)->get();

        $allProducts = Product::orderBy('created_at', 'desc')->paginate(6);

        // dd($allProducts);

        if ($request->wantsJson()) {
            return StorefrontProductResource::collection($allProducts);
        }

        return Inertia::render("Storefront", [
            'allProducts' => StorefrontProductResource::collection($allProducts),
            'carouselProducts' => ProductCarouselResource::collection($carouselProducts)
        ]);
    }
}
