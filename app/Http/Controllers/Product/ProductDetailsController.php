<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\RateProductRequest;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{
    public function AddRating(RateProductRequest $request, Product $product) {

        $validated = $request->validated();

        $userRatings = auth()->user()->ProductRatings;

        $alreadyRated = $userRatings->contains(function ($rating) use($product) {
            return $rating->product_id == $product->id;
        });

        if ($alreadyRated) {
            return redirect()->back()->withErrors(['rated' => 'You have already rated this product!']);
        }

        ProductRating::create([
            'rating' => $validated['rating'],
            'product_id' => $product->id,
            'rater' => auth()->user()->id
        ]);

        return redirect()->back()->with('message', 'Product rated!');

    }
}
