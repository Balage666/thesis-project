<?php

namespace App\Http\Controllers\Product;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Models\ProductComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\RateProductRequest;
use App\Http\Requests\Product\AddProductCommentRequest;

class ProductDetailsController extends Controller
{
    public function AddRating(RateProductRequest $request, Product $product) {

        $validated = $request->validated();
        // dd($validated);

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

    public function AddComment(AddProductCommentRequest $request, Product $product) {

        $validated = $request->validated();

        // dd($validated);

        $user = User::find(auth()->user()->id);
        $newComment = ProductComment::newModelInstance([
            'comment' => $validated['comment']
        ]);

        $newComment->CommentedProduct()->associate($product);
        $newComment->Commenter()->associate($user);

        $newComment->save();

        return redirect()->back()->with('message', 'Comment Added');

    }

    public function DeleteComment(ProductComment $comment) {

        $comment->delete();

        return redirect()->back()->with('message', 'Comment deleted!');

    }


}
