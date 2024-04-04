<?php

namespace App\Http\Controllers\Product;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Models\ProductComment;
use App\Models\ProductPicture;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\RateProductRequest;
use App\Http\Requests\Product\AddProductCommentRequest;
use App\Http\Requests\Product\ChangeProductNameRequest;
use App\Http\Requests\Product\ChangeProductPriceRequest;
use App\Http\Requests\Product\DeleteProductPicturesRequest;
use App\Http\Requests\Product\ChangeProductStockValueRequest;
use App\Http\Requests\Product\ChangeProductDescriptionRequest;

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

    public function DeleteRating(Request $request, Product $product) {

        $rating = $request['rating'];

        $foundRating = $product->Ratings()->find($rating['id']);

        if (!is_null($foundRating)) {
            $foundRating->delete();
        }


        return redirect()->back()->with('message', 'Rating deleted!');


    }

    public function AddComment(AddProductCommentRequest $request, Product $product) {

        $validated = $request->validated();

        $user = User::find(auth()->user()->id);
        $newComment = ProductComment::newModelInstance([
            'comment' => $validated['comment']
        ]);

        $newComment->CommentedProduct()->associate($product);
        $newComment->Commenter()->associate($user);

        $newComment->save();

        return redirect()->back()->with('message', 'Comment Added!');

    }

    public function DeleteComment(ProductComment $comment) {

        $comment->delete();

        return redirect()->back()->with('message', 'Comment deleted!');

    }

    public function ChangeProductName(ChangeProductNameRequest $request, Product $product) {
        $validated = $request->validated();

        $old = $product->name;


        $product->name = $validated['name'];

        if ($product->name == $old) {
            return back()->with('message', 'Product name stayed the same!');
        }

        $product->updated_at = now();
        $product->update();

        return redirect()->back()->with('message', 'Product name modified!');
    }

    public function ChangeProductDescription(ChangeProductDescriptionRequest $request, Product $product) {
        $validated = $request->validated();

        $old = $product->description;

        $product->price = $validated['description'];

        if ($product->description == $old) {
            return back()->with('message', 'Product description stayed the same!');
        }

        $product->updated_at = now();
        $product->update();

        return redirect()->back()->with('message', 'Product description modified!');
    }

    public function ChangeProductPrice(ChangeProductPriceRequest $request, Product $product) {

        $validated = $request->validated();

        $old = $product->price;

        $product->price = $validated['price'];

        if ($product->price == $old) {
            return back()->with('message', 'Product price stayed the same!');
        }

        $product->updated_at = now();
        $product->update();

        return redirect()->back()->with('message', 'Product price modified!');

    }

    public function ChangeProductStockValue(ChangeProductStockValueRequest $request, Product $product) {

        $validated = $request->validated();

        $old = $product->stock;

        $product->stock = $validated['stock'];

        if ($product->stock == $old) {
            return back()->with('message', 'Product stock stayed the same!');
        }

        $product->updated_at = now();
        $product->update();

        return redirect()->back()->with('message', 'Product stock modified!');

    }

    public function UploadProductPictures(Request $request, Product $product) {

        $fields = $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['required', 'mimes:jpg,png,jpeg']
        ]);

        $imageBag = $fields['images'];
        $dirPath = "uploads/products/images";

        try {
            foreach ($imageBag as $image) {

                $fileName = time().'_'.$image->getClientOriginalName();

                $imagePath = Storage::putFileAs("public/$dirPath", $image, $fileName);
                $publicPath = Str::replaceFirst('public/', '', $imagePath);

                $productPic = ProductPicture::newModelInstance([
                    'product_picture' => "/storage/$publicPath",
                ]);

                $product->Pictures()->save($productPic);

            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['upload' => 'Something went wrong!']);
        }

        return redirect()->back()->with('message', 'Pictures have successfully uploaded!');

    }

    public function DeleteProductPictures(DeleteProductPicturesRequest $request, Product $product) {

        $validated = $request->validated();

        $requestImages = $validated['images'];

        try {
            foreach ($requestImages as $requestImage) {
                $foundImg = $product->Pictures()->find($requestImage['id']);

                if (!is_null($foundImg)) {
                    $foundImg->delete();
                }

            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['delete' => 'Something went wrong!']);
        }


        return redirect()->back()->with('message', 'Selected pictures have been deleted!');

    }


}
