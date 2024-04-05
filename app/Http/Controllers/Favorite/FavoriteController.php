<?php

namespace App\Http\Controllers\Favorite;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function AddToFavorites(User $user, Product $product) {

        $newFavoriteProduct = Favorite::newModelInstance([]);

        $newFavoriteProduct->Product()->associate($product);

        $user->Favorites()->save($newFavoriteProduct);

        return redirect()->back()->with('message', 'Added to Favorites!');
    }

    public function RemoveFromFavorites(User $user, Product $product) {

        $foundProduct = $user->Favorites()->whereHas('Product', function ($query) use($product) {
            $query->where('id', '=', $product->id);
        })->first()->Product;


        if (is_null($foundProduct)) {
            return redirect()->back()->withErrors(['favorite' => 'This product is not in your favorites yet!']);
        }

        $user->Favorites()->whereHas('Product', function ($query) use($product) {
            $query->where('id', '=', $product->id);
        })->first()->delete();


        return redirect()->back()->with('message', 'Product removed from favorites!');

    }
}
